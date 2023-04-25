<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;
use Hash;

class UserController extends Controller
{
    function index() {
        return view('profile');
    }

    function privacySecurity() {
        return view('privacy-security');
    }

    function adminUsers() {
        $users = User::all();
        return view('adminUsers')->with('users', $users);
    }

    function userInfo(User $user) {
        return view('userInfo')->with('user', $user);
    }

    // Cambia la foto de perfil y elimina la anterior
    function updatePic(User $user, Request $request) {
        if(!$request->hasFile('new_pic')) {
            return back()->with('error', 'No file provided');
        }
        $path = $request->file('new_pic')->store('profile_pics', 'public');

        if ($user->profile_pic != 'None') {
            Storage::delete('public/'.$user->profile_pic);
        }

        $user->update([
            'profile_pic'   =>  $path
        ]);
        $user->updateTimestamps();

        return back()->with('success', 'Picture uploaded');
    }

    // Elimina la foto de perfil
    function deletePic(User $user, Request $request) {
        if ($user->profile_pic != 'None') {
            Storage::delete('public/'.$user->profile_pic);
        }

        $user->update([
            'profile_pic'   =>  'None'
        ]);
        $user->updateTimestamps();

        return back()->with('success', 'Picture deleted');
    }

    // Actualiza el nombre y el correo del usuario
    function updateInfo(User $user, Request $request) {
        $modification = $user->name !== $request->name || $user->email !== $request->email;
        // si se ha modificado el nombre o el email, validamos los datos y actualizamos la base de datos
        if($user->name !== $request->name) {
            $request->validate(['name'  =>  ['string', 'max:255', 'unique:'.User::class]]);
            $user->update(['name'  =>  $request->name]);
        }
        if($user->email !== $request->email) {
            $request->validate(['email'     =>  ['string', 'max:255', 'email', 'unique:'.User::class]]);
            $user->update(['email' =>  $request->email]);
        }
        $user->updateTimestamps();

        if($modification) {
            return back()->with('success', 'All changes were saved correctly');
        }
        else {
            return back()->with('success', 'No data was modified');
        }

    }

    // Cambia la contraseña del usuario (logeado)
    function changePassword(User $user, Request $request) {
        $request->validate([
            'old_password'  =>  'required',
            'new_password'  =>  ['required', 'confirmed', Rules\Password::defaults()]
        ]);

        if(!Hash::check($request->old_password, $user->password)) {
            return back()->with('error', 'Old password is not correct');
        }
        elseif(Hash::check($request->old_password, HASH::make($request->new_password))) {
            return back()->with('error', 'You can\'t use the same password');
        }

        $user->update(['password' =>  Hash::make($request->new_password)]);
        $user->updateTimestamps();

        return back()->with('success', 'Your password was changed correctly');
    }

    // Si el usuario tiene ban, se lo quita y viceversa
    function ban(User $user) {
        if($user->ban) {
            $user->update(['ban' =>  0]);
            return back()->with('success', 'The user '.$user->name.' was unbanned!');
        }
        $user->update(['ban' =>  1]);
        return back()->with('success', 'The user '.$user->name.' was banned!');
    }

    // Elimina el usuario de la base de datos
    function delete(User $user) {
        if(Auth::user()->isAdmin() || Auth::id() == $user->id) {
            $user->delete();
            return back()->with('success', 'The account was deleted successfully!');
        }
        return back();
    }
}
