<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Offer;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\OfferRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;



class OfferController extends Controller
{
    function home2() {


        // Obtener todas las ofertas
        $offers = Offer::all()->sortBy('title');

        if(Auth::guest()) {
            return view('homeGuest');
        }

        return view('homeOffer')->with([
            'offers' => $offers

        ]);
    }


    //Devuelve la vista con los resultados de buscar por título
    function OfferResults(Request $request) {
        $offer_salary = 0;

        if ($request->filled('offer_title')) {
            if($request->filled('offer_salary')) {
                $offer_salary = $request->input('offer_salary');
            }
            $offers = Offer::where('title', 'LIKE', "%{$request->offer_title}%")
                ->where('salary', '>=', $offer_salary)
                ->latest()
                ->get();

            return view('homeOffer')->with([
                'offers'    =>  $offers,
                'offer_title'     =>  $request->offer_title,
                'offer_salary'     =>  $request->offer_salary
            ]);
        } else {
            if($request->filled('offer_salary')) {
                $offer_salary = $request->input('offer_salary');
                $offers = Offer::where('salary', '>=', $offer_salary)
                ->latest()
                ->get();

                return view('homeOffer')->with([
                    'offers'    =>  $offers,
                    'offer_salary'     =>  $request->offer_salary
                ]);
            }
            return redirect()->route("home-2");
        }
    }

    // Devuelve la vista de la página de administración de vídeos
    function adminOffers() {
        $offers = Offer::all();

        return view('adminOffers')->with('offers',$offers);
    }


    // Devuelve la vista para crear una nueva oferta
    function newOffer() {
        return view('newOffer');
    }


    // Devuelve la vista de todas las ofertas de un usuario
    function myOffers(Request $request) {
        if($request->filled('offer_title')) {
            $filtered_offers = Auth::user()->offers()->where('title', 'LIKE', "%{$request->offer_title}%")->get();
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
    function uploadOffer(User $user, OfferRequest $request) {
        if(!$request->hasFile('offer')) {
            return back()->with('error', 'No file provided for offer');
        }

        // Creamos la oferta para poder relacionarla nada mas crearlas con el owner id
        $offer = $user->offers()->create([
            'title' =>  $request->title,
            'salary'   =>  $request->salary,
            'description'   =>  $request->description,
            'vacants'   =>  $request->vacants,
            'document_path' =>  ''
        ]);

        // Escapamos el titulo de la oferta de cara a guardarlo en carpetas
        $escaped_title = preg_replace('/[^A-Za-z0-9_\-]/', '_', $request->title);


        $offer_file = $request->file('offer');

        $offer_extension = strtolower($offer_file->getClientOriginalExtension());

        $date = date('YmdHis');
        //Asignamos un nombre a la carpeta que contiene la oferta
        $folder = 'offers/';
        // Asignamos un nombre al fichero de offer
        $offer_name = 'wishten-'.$date.'-'.$offer->title.'.'.$offer_extension;
        $document_path = $offer_file->storeAs($folder, $offer_name, 'public');
        $offer->document_path = $document_path;
        $offer->save();
        return back()->with('success', 'Your offer was uploaded successfully!' );
    }

    function setTitleOffer(Offer $offer, Request $request) {
        if(Auth::user()->cannot('update', $offer)) {
            abort(403);
        }

        $request->validate(['title' => ['required', 'string', 'max:255']]);

        $new_title = preg_replace('/[^A-Za-z0-9_\-]/', '_', $request->title);

        if ($new_title !== $offer->title) {
            // Obtener la extensión del archivo original
            $extension = pathinfo($offer->document_path, PATHINFO_EXTENSION);

            // Crear el nuevo nombre del archivo con el nuevo título y extensión
            $date = date('YmdHis');
            $new_offer_name = 'wishten-'.$date.'-'.$new_title.'.'.$extension;

            // Obtener la ruta de la carpeta "offers"
            $offers_folder = pathinfo($offer->document_path, PATHINFO_DIRNAME);

            // Crear la nueva ruta completa del archivo
            $new_offer_path = $offers_folder.'/'.$new_offer_name;

            // Mover el archivo con el nuevo nombre y en la misma carpeta "offers"
            if (Storage::move('public/'.$offer->document_path, 'public/'.$new_offer_path)) {
                // Actualizar el título y la ruta del documento en la base de datos
                $offer->update(['title' => $request->title, 'document_path' => $new_offer_path]);
            } else {
                // Si no se pudo mover el archivo, solo actualiza el título en la base de datos
                $offer->update(['title' => $request->title]);
            }
        } else {
            // Si no se cambió el título, solo actualiza el título en la base de datos
            $offer->update(['title' => $request->title]);
        }

        return back()->with('success', 'The offer title was changed');
    }
    // Actualiza la descripción de la oferta
    function setDescOffer(Offer $offer, Request $request) {
        if(Auth::user()->cannot('update', $offer)) {
            abort(403);
        }

        $request->validate(['description'   =>  ['required', 'string', 'max:255']]);
        $offer->update(['description'   =>  $request->description]);
        $offer->save();
        return back()->with('success', 'The offer description was changed');
    }

    // Actualiza el salario de la oferta
    function setSalaryOffer(Offer $offer, Request $request) {
        if(Auth::user()->cannot('update', $offer)) {
            abort(403);
        }

        $request->validate(['salary'   =>  ['required', 'numeric']]);
        $offer->update(['salary'   =>  $request->salary]);
        $offer->save();
        return back()->with('success', 'The offer salary was changed');
    }

    // Actualiza la descripción de laa oferta
    function setVacantsOffer(Offer $offer, Request $request) {
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
    function deleteOffer(Offer $offer, bool $admin) {
        if(Auth::user()->cannot('delete', $offer)) {
            abort(403);
        }
        Storage::delete('public/'.$offer->document_path);
        $offer->delete();
        // Si viene de la pagina de administración, le devolvemos a la misma
        if ($admin) {
            return back()->with('success', 'Your offer was deleted successfully!');
        }
        return redirect(route('my-offers'))->with('success', 'Your offer was deleted successfully!');
    }
    // Devuelve la vista para editar una offer
function editOffer(Request $request) {
    $offer = Offer::find($request['offer']);

    // Si el usuario no está autorizado para editar la oferta(no es company o admin), se le deniega el acceso
    if(Auth::user()->cannot('update', $offer)) {
        abort(403);
    }

    return view('offerEdit')->with([
        'offer'     =>  $offer
    ]);
}
}


