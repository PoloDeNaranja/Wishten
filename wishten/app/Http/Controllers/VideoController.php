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
    function myVideos() {
        return view('myVideos')->with('videos', Auth::user()->videos()->get());
    }

    // Crea un nuevo vídeo, asignándoselo al usuario que lo crea
    function upload(User $user, VideoRequest $request) {
        if(!$request->hasFile('video')) {
            return back()->with('error', 'No file provided');
        }
        // Escapamos el titulo y el tema del video para darle nombre al fichero y a la carpeta
        $escaped_title = preg_replace('/[^A-Za-z0-9_\-]/', '_', $request->title);
        $escaped_subject = preg_replace('/[^A-Za-z0-9_\-]/', '_', $request->subject_name);
        $video = $request->file('video');
        $format = strtolower($video->getClientOriginalExtension());
        $allowed_formats = array('mp4', 'mov', 'wmv', 'flv', 'avi');
        if (!in_array($format, $allowed_formats)) {
            return back()->with('error', 'Invalid file format, the formats allowed are: .MP4, .MOV, .WMV, .FLV or .AVI');
        }
        $date = date('YmdHis');
        $filename = 'wishten-'.$date.'_'.$escaped_title.'.'.$format;
        $folder = 'videos/'.$escaped_subject.'/'.$escaped_title.'_'.$date;
        $path = $request->file('video')->storeAs($folder, $filename, 'public');

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
