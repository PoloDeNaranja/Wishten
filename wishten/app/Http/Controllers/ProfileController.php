<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
//use League\Flysystem\WhitespacePathNormalizer;

class ProfileController extends Controller
{
    function index() {
        return view('profile');
    }

    function update_pic(Request $request) {
        $userId = Auth::id();
        $user = User::findOrFail($userId);
        if(!$request->hasFile('new_pic')) {
            return redirect('profile')->with('error', 'No file provided');
        }
        $path = $request->file('new_pic')->store('profile_pics', 'public');

        if ($user->profile_pic != 'None') {
            Storage::delete('public/'.$user->profile_pic);
        }

        $user->update([
            'profile_pic'   =>  $path
        ]);
        $user->updateTimestamps();

        return redirect('profile')->with('success', 'Picture uploaded');
    }
}
