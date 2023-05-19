<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;
use App\Models\User;
use App\Models\Subject;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\VideoRequest;
use Illuminate\Support\Facades\Storage;


class VideoController extends Controller
{

    function index() {
        $videos = Video::all()->take(10);
        return view('videos')->with('videos', $videos);
    }

    // Devuelve la vista de un vídeo
    function watch(Request $request) {
        $video = Video::find($request['video']);
        return view('videoWatch')->with('video', $video);
    }

    // Devuelve la vista para editar un vídeo
    function edit(Request $request) {
        $video = Video::find($request['video']);
        return view('videoEdit')->with('video', $video);
    }

    // Devuelve la vista para crear un nuevo vídeo
    function newVideo() {
        $subjects = Subject::all()->sortBy('name');
        return view('newVideo')->with('subjects', $subjects);
    }

    // Devuelve la vista de todos los vídeos de un usuario
    function myVideos() {
        return view('myVideos')->with('videos', Auth::user()->videos()->get());
    }

    // Crea un nuevo vídeo, asignándoselo al usuario que lo crea
    function upload(User $user, VideoRequest $request) {
        if(!$request->hasFile('video')) {
            return back()->with('error', 'No file provided');
        }
        $path = $request->file('video')->store('videos', 'public');

        $video = $user->videos()->create([
            'title' =>  $request->title,
            'description'   =>  $request->description,
            'file_path' =>  $path,
        ]);

        $subject = Subject::firstOrCreate([
            'name'  =>  $request->subject_name
        ]);

        $video->subject()->associate($subject);
        $video->save();
        return back()->with('success', 'Your video was uploaded successfully!');
    }

    // Elimina la información de un video de la base de datos y el fichero asociado
    function delete(Video $video) {
        if(Auth::user()->isAdmin() || Auth::id() == $video->owner_id) {
            Storage::delete('public/'.$video->file_path);
            $video->delete();
            return redirect(route('my-videos'))->with('success', 'Your video was deleted successfully!');
        }
        return back();
    }
}
