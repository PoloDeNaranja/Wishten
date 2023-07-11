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
                'videos'    =>  $subject->videos()->where('status', 'valid')->get(),
                'subjects'  =>  $subjects,
                'subject_name'  =>  $subject->name
            ]);
        }
        else {
            $videos = Video::all()->where('status', 'valid')->take(10);
            return view('videos')->with([
                'videos'    =>  $videos,
                'subjects'  =>  $subjects
            ]);
        }
    }

    // Devuelve la vista de la página de administración de vídeos
    function adminVideos() {
        $videos = Video::all();
        $subjects = Subject::all()->sortBy('name');
        return view('adminVideos')->with([
            'videos'    =>  $videos,
            'subjects'  =>  $subjects
        ]);
    }


    // Devuelve la vista de un vídeo
    function watch(Request $request) {
        $video = Video::find($request['video']);
        // Los videos bloqueados solo los puede ver su dueño
        if(Auth::user()->cannot('view', $video)) {
            abort(404);
        }
        if(!Auth::user()->hasViewed($video)) {
            Auth::user()->visualized_videos()->attach($video, ['date'=>date("Y-m-d H:i:s")]);
        }
        return view('videoWatch')->with(['video' =>  $video]);
    }

    // Devuelve la vista para editar un vídeo
    function edit(Request $request) {
        $video = Video::find($request['video']);

        // Si el usuario no está autorizado para editar el video, se le deniega el acceso
        if(Auth::user()->cannot('update', $video)) {
            abort(403);
        }

        $subjects = Subject::all()->sortBy('name');
        return view('videoEdit')->with([
            'video'     =>  $video,
            'subjects'   =>  $subjects
        ]);
    }

    // Devuelve la vista de estadísticas del vídeo
    function stats(Request $request) {
        $video = Video::find($request['video']);

        // Si el usuario no está autorizado para editar el video, se le deniega el acceso
        if(Auth::user()->cannot('update', $video)) {
            abort(403);
        }

        return view('videoStats')->with('video', $video);
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

        // Creamos el video primero ya que usaremos su ID para identificar los ficheros asociados
        $video = $user->videos()->create([
            'title' =>  $request->title,
            'description'   =>  $request->description,
            'video_path' =>  '',
            'thumb_path' =>  ''
        ]);

        // Escapamos el titulo y el tema del video para darle nombre a las carpetas
        $escaped_title = preg_replace('/[^A-Za-z0-9_\-]/', '_', $request->title);
        $escaped_subject = preg_replace('/[^A-Za-z0-9_\-]/', '_', $request->subject_name);

        $video_file = $request->file('video');
        $thumb = $request->file('thumbnail');

        $video_extension = strtolower($video_file->getClientOriginalExtension());
        $thumb_extension = strtolower($thumb->getClientOriginalExtension());
        $date = date('YmdHis');
        //Asignamos un nombre a la carpeta que contiene el video y la miniatura
        $folder = 'videos/'.$escaped_subject.'/'.$escaped_title.'_'.$date;
        // Asignamos un nombre a los ficheros de video y de miniatura
        $video_name = 'wishten-'.$date.'-'.$video->id.'.'.$video_extension;
        $thumb_name = 'wishten-'.$date.'-'.$video->id.'-thumbnail.'.$thumb_extension;
        $video_path = $video_file->storeAs($folder, $video_name, 'public');
        $thumb_path = $thumb->storeAs($folder, $thumb_name, 'public');

        $video->video_path = $video_path;
        $video->thumb_path = $thumb_path;

        $subject = Subject::firstOrCreate([
            'name'  =>  $request->subject_name
        ]);

        $video->subject()->associate($subject);
        $video->save();
        return back()->with('success', 'Your video was uploaded successfully!');
    }

    // Actualiza el título de un video
    function setTitle(Video $video, Request $request) {
        if(Auth::user()->cannot('update', $video)) {
            abort(403);
        }

        $request->validate(['title' =>  ['required', 'string', 'max:255']]);

        // Si se cambia el título del video, se reubican los ficheros asociados
        if($request->title !== $video->title) {
            // Separamos el string que contiene la ruta para poder mover los ficheros a la nueva ruta
            list($videos, $subject, $old_title, $video_file) = explode('/', $video->video_path);
            $thumb_file = explode('/', $video->thumb_path)[3];

            $escaped_title = preg_replace('/[^A-Za-z0-9_\-]/', '_', $request->title);
            $date = date('YmdHis');

            $new_video_path = $videos.'/'.$subject.'/'.$escaped_title.'_'.$date.'/'.$video_file;
            $new_thumb_path = $videos.'/'.$subject.'/'.$escaped_title.'_'.$date.'/'.$thumb_file;
            // Movemos los ficheros a la nueva ruta y eliminamos la carpeta anterior
            Storage::move('public/'.$video->video_path, 'public/'.$new_video_path);
            Storage::move('public/'.$video->thumb_path, 'public/'.$new_thumb_path);
            Storage::deleteDirectory('public/'.$videos.'/'.$subject.'/'.$old_title);
            $video->update([
                'video_path'    =>  $new_video_path,
                'thumb_path'    =>  $new_thumb_path
            ]);

        }

        $video->update(['title' =>  $request->title]);
        $video->updateTimestamps();
        $video->save();
        return back()->with('success', 'The video title was changed');
    }

    // Actualiza la descripción del video
    function setDesc(Video $video, Request $request) {
        if(Auth::user()->cannot('update', $video)) {
            abort(403);
        }

        $request->validate(['description'   =>  ['required', 'string', 'max:255']]);
        $video->update(['description'   =>  $request->description]);
        $video->updateTimestamps();
        $video->save();
        return back()->with('success', 'The video description was changed');
    }

    // Actualiza el tema del vídeo
    function setSubject(Video $video, Request $request) {
        if(Auth::user()->cannot('update', $video)) {
            abort(403);
        }

        $subject = Subject::firstOrCreate([
            'name'  =>  $request->subject_name
        ]);
        // Si se cambia el tema del video, se reubican los ficheros asociados
        if($subject->id != $video->subject_id) {
            // Separamos el string que contiene la ruta para poder mover los ficheros a la nueva ruta
            list($videos, $old_subject, $title, $video_file) = explode('/', $video->video_path);
            $thumb_file = explode('/', $video->thumb_path)[3];

            $escaped_subject = preg_replace('/[^A-Za-z0-9_\-]/', '_', $request->subject_name);

            $new_video_path = $videos.'/'.$escaped_subject.'/'.$title.'/'.$video_file;
            $new_thumb_path = $videos.'/'.$escaped_subject.'/'.$title.'/'.$thumb_file;
            // Movemos los ficheros a la nueva ruta y eliminamos la carpeta anterior
            Storage::move('public/'.$video->video_path, 'public/'.$new_video_path);
            Storage::move('public/'.$video->thumb_path, 'public/'.$new_thumb_path);
            Storage::deleteDirectory('public/'.$videos.'/'.$old_subject.'/'.$title);
            $video->update([
                'video_path'    =>  $new_video_path,
                'thumb_path'    =>  $new_thumb_path
            ]);

        }
        $video->subject()->associate($subject);
        $video->updateTimestamps();
        $video->save();
        return back()->with('success', 'The video subject was changed');
    }

    // Actualiza la miniatura del video
    function setThumbnail(Video $video, Request $request) {
        if(Auth::user()->cannot('update', $video)) {
            abort(403);
        }

        if(!$request->hasFile('thumbnail')) {
            return back()->with('error', 'No file provided for the thumbnail');
        }
        $request->validate(['thumbnail' =>  ['required', 'mimes:jpg,jpeg,png']]);

        // Eliminamos el fichero anterior
        Storage::delete('public/'.$video->thumb_path);

        list($videos, $subject, $title, $thumb_file) = explode('/', $video->thumb_path);
        $thumb = $request->file('thumbnail');
        // Guardamos el nuevo fichero con el mismo nombre que tenía el anterior
        $thumb->storeAs($videos.'/'.$subject.'/'.$title, $thumb_file, 'public');
        $video->updateTimestamps();
        return back()->with('success', 'The thumbnail was changed');
    }

    // Actualiza el estado del video (valid, pending, blocked)
    function setStatus(Video $video, Request $request) {
        if($video->status == $request->status) {
            return back()->with('success', 'No data was modified');
        }
        $video->update(['status' =>  $request->status]);
        return back()->with('success', 'The video '.$video->title.' is in '.strtoupper($video->status).' status');
    }

    // Marca el video como favorito para que sea más accesible para el usuario
    function fav(Video $video, User $user) {
        if($video->isFav($user)) {
            $video->views()->where('user_id', $user->id)->update(['fav'=>0, 'date'=>date("Y-m-d H:i:s")]);
            $video->save();
            return back()->with('success', 'This video was removed from your favourite videos');
        }
        $video->views()->where('user_id', $user->id)->update(['fav'=>1, 'date'=>date("Y-m-d H:i:s")]);
        $video->save();
        return back()->with('success', 'This video was added to your favourite videos');
    }

    // Elimina la información de un video de la base de datos y el fichero asociado
    function delete(Video $video, bool $admin) {
        if(Auth::user()->cannot('delete', $video)) {
            abort(403);
        }
        Storage::delete('public/'.$video->video_path);
        Storage::delete('public/'.$video->thumb_path);
        // Eliminamos la carpeta que contenía los ficheros de ese video
        list($videos, $subject, $title, $_) = explode('/', $video->video_path);
        Storage::deleteDirectory('public/'.$videos.'/'.$subject.'/'.$title);
        $video->delete();
        // Si viene de la pagina de administración, le devolvemos a la misma
        if ($admin) {
            return back()->with('success', 'Your video was deleted successfully!');
        }
        return redirect(route('my-videos'))->with('success', 'Your video was deleted successfully!');
    }
}
