<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Offer;
use App\Models\User;
use App\Models\Chart;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\OfferRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;



class OfferController extends Controller
{
    
    // Devuelve la vista con los resultados de búsqueda
    // function results(Request $request) {
    //     $subjects = Subject::all()->sortBy('name');
    //     if($request->filled('subject_name')) {
    //         $subject = Subject::firstWhere('name', 'LIKE', "%{$request->subject_name}%");
    //         // Se devuelve la vista con los vídeos que pertenezcan al tema buscado, si éste existe
    //         if(!$subject) {
    //             return view('videoList')->with([
    //                 'videos'    =>  null,
    //                 'subjects'  =>  $subjects,
    //                 'subject_name'  =>  $request->subject_name,
    //                 'title'     =>  $request->subject_name
    //             ]);
    //         }
    //         return view('videoList')->with([
    //             'videos'    =>  $subject->videos()->where('status', 'valid')->latest()->get(),
    //             'subjects'  =>  $subjects,
    //             'subject_name'  =>  $request->subject_name,
    //             'title'     =>  $request->subject_name
    //         ]);
    //     }
    //     else {
    //         // Si no se ha buscado nada, se vuelve a la vista home
    //         return redirect()->route("home");
    //     }
    // }

    function download($document){
        $filePath = storage_path('app/public/' . $document);
        if (file_exists($filePath)) {
            return response()->download($filePath);
        } else {
        abort(404, 'El documento no existe.');
        }
        // <a href="{{ route('download.document', ['document' => $offer->document_path]) }}" class="btn btn-primary">
        
        // </a>
    }

    // Devuelve la vista con las ofertas de un usuario
    function useroffers(Request $request) {
        $user = User::find($request['user']);
        if(!$user) {
            abort(404);
        }
        $offers = $user->offers()->latest()->get();
        return view('offerLista')->with([
            'offers'    =>  $offers,
            'title'     =>  $user->name.'\' Videos'
        ]);
    }

    

    // Devuelve la vista de la página de administración de vídeos
    function adminOffers() {
        $videos = Offer::all();
        
        return view('adminOffers')->with([
            'offers'    =>  $offers,
        ]);
    }

    // Devuelve la vista para crear una nueva oferta
    function newOffer() {
        return view('newOffer');
    }

    // Devuelve la vista de todas las ofertas de un usuario
    function myOffers(Request $request) {
        if($request->filled('offer_title')) {
            $filtered_offers = Auth::user()->offers()->where('title', $request->offer_title)->get();
            if(!$filtered_offers) {
                return view('myOffers')->with([
                    'offers'    =>  null,
                    'offer_title'  =>  $request->offer_title
                ]);
            }
            return view('myOffers')->with([
                'offers'    =>  $filtered_offers,
                'offer_title'  =>  $request->offer_title
            ]);
        }
        else {
            $offers = Auth::user()->offers()->get();
            return view('myOffers')->with([
                'offers'    =>  $offers,
            ]);
        }
    }



    // Crea una nueva oferta
    function upload(User $user, OfferRequest $request) {
        if(!$request->hasFile('offer')) {
            return back()->with('error', 'No file provided for offer');
        }

        // Creamos la oferta para poder relacionarla nada mas crearlas con el owner id
        $offer = $user->offers()->create([
            'title' =>  $request->title,
            'salary'   =>  $request->salary,
            'description'   =>  $request->description,
            'vacants'   =>  $request->vacants,
            'offer_path' =>  ''
        ]);

        // Escapamos el titulo de la oferta de cara a guardarlo en carpetas
        $escaped_title = preg_replace('/[^A-Za-z0-9_\-]/', '_', $request->title);
        

        $offer_file = $request->file('offer');

        $offer_extension = strtolower($video_file->getClientOriginalExtension());
        
        $date = date('YmdHis');
        //Asignamos un nombre a la carpeta que contiene el video y la miniatura
        $folder = 'videos/'.$escaped_title.'_'.$date;
        // Asignamos un nombre al fichero de offer
        $offer_name = 'wishten-'.$date.'-'.$offer->id.'.'.$offer_extension;
        $offer_path = $offer_file->storeAs($folder, $offer_name, 'public');
        $offer->offer_path = $offer_path;
        $offer->save();
        return back()->with('success', 'Your offer was uploaded successfully!' );
    }

    // Actualiza el título de una oferta
    function setTitle(Offer $offer, Request $request) {
        if(Auth::user()->cannot('update', $offer)) {
            abort(403);
        }

        $request->validate(['title' =>  ['required', 'string', 'max:255']]);

        // Si se cambia el título del video, se reubican los ficheros asociados
        if($request->title !== $offer->title) {
            list($offer,$old_title, $offer_file) = explode('/', $offer->offer_path);

            $escaped_title = preg_replace('/[^A-Za-z0-9_\-]/', '_', $request->title);
            $date = date('YmdHis');

            $new_docu_path = $offers.'/'.$escaped_title.'_'.$date.'/'.$offer_file;
            
            //actualizamos ficheros cambiandolos de carpeta y borramos
            Storage::move('public/'.$offer->offer_path, 'public/'.$new_offer_path);
            Storage::deleteDirectory('public/'.$offers.'/'.$old_title);
            $video->update([
                'offer_path'    =>  $new_offer_path
            ]);

        }

        $offer->update(['title' =>  $request->title]);
        $offer->save();
        return back()->with('success', 'The offer title was changed');
    }

    // Actualiza la descripción de la oferta
    function setDesc(Offer $offer, Request $request) {
        if(Auth::user()->cannot('update', $offer)) {
            abort(403);
        }

        $request->validate(['description'   =>  ['required', 'string', 'max:255']]);
        $offer->update(['description'   =>  $request->description]);
        $offer->save();
        return back()->with('success', 'The offer description was changed');
    }

    // Actualiza el salario de la oferta
    function setSalary(Offer $offer, Request $request) {
        if(Auth::user()->cannot('update', $offer)) {
            abort(403);
        }

        $request->validate(['salary'   =>  ['required', 'numeric']]);
        $offer->update(['salary'   =>  $request->salary]);
        $offer->save();
        return back()->with('success', 'The offer salary was changed');
    }

    // Actualiza la descripción del video
    function setVacants(Offer $offer, Request $request) {
        if(Auth::user()->cannot('update', $offer)) {
            abort(403);
        }

        $request->validate(['vacants'   =>  ['required', 'numeric']]);
        $offer->update(['vacants'   =>  $request->vacants]);
        $offer->updateTimestamps();
        $offer->save();
        return back()->with('success', 'The offer vacants was changed');
    }

    
    // Elimina la información de una oferta
    function delete(Offer $offer, bool $admin) {
        if(Auth::user()->cannot('delete', $offer)) {
            abort(403);
        }
        Storage::delete('public/'.$offer->offer_path);
        
        // Eliminamos la carpeta que contenía los ficheros de esa oferta
        list($offer, $title, $_) = explode('/', $offer->offer_path);
        Storage::deleteDirectory('public/'.$offers.'/'.$title);
        $offer->delete();
        // Si viene de la pagina de administración, le devolvemos a la misma
        if ($admin) {
            return back()->with('success', 'Your offer was deleted successfully!');
        }
        return redirect(route('my-offers'))->with('success', 'Your offer was deleted successfully!');
    }
}
