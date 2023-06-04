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
    // Devuelve la vista con todos los videos o aplicando el filtro por temas
    function index(Request $request) {
        $subjects = Subject::all()->sortBy('name');
        if($request->filled('subject_name')) {
            $subject = Subject::firstWhere('name', $request->subject_name);
            if(!$subject) {
                return view('videos')->with([
                    'videos'    =>  null,
                    'subjects'  =>  $subjects,
                    'subject_name'  =>  $request->subject_name
                ]);
            }
            return view('videos')->with([
                'videos'    =>  $subject->videos()->get(),
                'subjects'  =>  $subjects,
                'subject_name'  =>  $subject->name
            ]);
        }
        else {
            $videos = Video::all()->take(10);
            return view('videos')->with([
                'videos'    =>  $videos,
                'subjects'  =>  $subjects
            ]);
        }
    }

    function adminVideos() {
        $videos = Video::all();
        return view('adminVideos')->with('videos', $videos);
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
    function myVideos(Request $request) {
        if($request->filled('video_title')) {
            $filtered_videos = Auth::user()->videos()->where('title', $request->video_title)->get();
            if(!$filtered_videos) {
                return view('myVideos')->with([
                    'videos'    =>  null,
                    'video_title'  =>  $request->video_title
                ]);
            }
            return view('myVideos')->with([
                'videos'    =>  $filtered_videos,
                'video_title'  =>  $request->video_title
            ]);
        }
        else {
            $videos = Auth::user()->videos()->get();
            return view('myVideos')->with([
                'videos'    =>  $videos,
            ]);
        }
    }

    // Crea un nuevo vídeo, asignándoselo al usuario que lo crea
    function upload(User $user, VideoRequest $request) {
        if(!$request->hasFile('video') || !$request->hasFile('thumbnail')) {
            return back()->with('error', 'No file provided for video or thumbnail');
        }
        // Escapamos el titulo y el tema del video para darle nombre al fichero y a la carpeta
        $escaped_title = preg_replace('/[^A-Za-z0-9_\-]/', '_', $request->title);
        $escaped_subject = preg_replace('/[^A-Za-z0-9_\-]/', '_', $request->subject_name);

        $video = $request->file('video');
        $thumb = $request->file('thumbnail');

        $video_extension = strtolower($video->getClientOriginalExtension());
        $thumb_extension = strtolower($thumb->getClientOriginalExtension());
        $date = date('YmdHis');
        //Asignamos un nombre a la carpeta que contiene el video y la miniatura
        $folder = 'videos/'.$escaped_subject.'/'.$escaped_title.'_'.$date;
        // Asignamos un nombre a los ficheros de video y de miniatura
        $video_name = 'wishten-'.$date.'-'.$escaped_title.'.'.$video_extension;
        $thumb_name = 'wishten-'.$date.'-'.$escaped_title.'-thumbnail.'.$thumb_extension;
        $video_path = $video->storeAs($folder, $video_name, 'public');
        $thumb_path = $thumb->storeAs($folder, $thumb_name, 'public');

        $video = $user->videos()->create([
            'title' =>  $request->title,
            'description'   =>  $request->description,
            'video_path' =>  $video_path,
            'thumb_path' =>  $thumb_path
        ]);

        $subject = Subject::firstOrCreate([
            'name'  =>  $request->subject_name
        ]);

        $video->subject()->associate($subject);
        $video->save();
        return back()->with('success', 'Your video was uploaded successfully!');
    }

    // Elimina la información de un video de la base de datos y el fichero asociado
    function delete(Video $video, bool $admin) {
        if(Auth::user()->isAdmin() || Auth::id() == $video->owner_id) {
            Storage::delete('public/'.$video->file_path);
            $video->delete();
            if ($admin) {
                return back()->with('success', 'Your video was deleted successfully!');
            }
            return redirect(route('my-videos'))->with('success', 'Your video was deleted successfully!');
        }
        return back();
    }
}
