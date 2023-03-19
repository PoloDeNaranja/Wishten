<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\VideoRequest;

class VideoController extends Controller
{
    // Devuelve la vista de un vídeo
    function watch(Video $video) {
        return view('video')->with('video', $video);
    }

    // Devuelve la vista para crear un nuevo vídeo
    function newVideo() {
        return view('newVideo');
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

        $user->videos()->create([
            'title' =>  $request->title,
            'description'   =>  $request->description,
            'file_path' =>  $path
        ]);

        return back()->with('success', 'Your video was uploaded correctly!');
    }
}
