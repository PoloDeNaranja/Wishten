<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;
use App\Models\User;
use App\Http\Requests\VideoRequest;

class VideoController extends Controller
{
    function watch(Video $video) {
        return view('video')->with('video', $video);
    }

    function newVideo() {
        return view('newVideo');
    }

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
        // Video::create([
        //     'owner_id'  =>  $user->id,
        //     'title' =>  $request->title,
        //     'description'   =>  $request->description,
        //     'file_path' =>  $path
        // ]);
    }
}
