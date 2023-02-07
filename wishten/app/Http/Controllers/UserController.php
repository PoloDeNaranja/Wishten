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

    function privacy_security() {
        return view('privacy-security');
    }

    // Cambia la foto de perfil y elimina la anterior
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

    // Elimina la foto de perfil
    function delete_pic(Request $request) {
        $userId = Auth::id();
        $user = User::findOrFail($userId);
        if ($user->profile_pic != 'None') {
            Storage::delete('public/'.$user->profile_pic);
        }

        $user->update([
            'profile_pic'   =>  'None'
        ]);
        $user->updateTimestamps();

        return redirect('profile')->with('success', 'Picture deleted');
    }

    // Actualiza el nombre y el correo del usuario
    function update_info(Request $request) {
        $userId = Auth::id();
        $user = User::findOrFail($userId);
        $modification = $user->name !== $request->username || $user->email !== $request->email;
        // si se ha modificado el nombre o el email, validamos los datos y actualizamos la base de datos
        if($user->name !== $request->username) {
            $request->validate(['username'  =>  ['string', 'max:255']]);
            $user->update(['name'  =>  $request->username]);
        }
        if($user->email !== $request->email) {
            $request->validate(['email'     =>  ['string', 'max:255', 'email', 'unique:'.User::class]]);
            $user->update(['email' =>  $request->email]);
        }
        $user->updateTimestamps();

        if($modification) {
            return redirect('profile')->with('success', 'All changes were saved correctly');
        }
        else {
            return redirect('profile')->with('success', 'No data was modified');
        }

    }

    // Cambia la contraseña del usuario (logeado)
    function change_password(Request $request) {
        $userId = Auth::id();
        $user = User::findOrFail($userId);
        echo($userId);

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


}
