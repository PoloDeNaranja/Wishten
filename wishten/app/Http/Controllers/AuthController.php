<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Hash;
use Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;
use App\Http\Requests\RegistrationRequest;
use App\Http\Requests\LoginRequest;



class AuthController extends Controller
{
    // Devuelve la vista con el formulario de login
    function index() {
        return view('login');
    }

    // Devuelve la vista con el formulario de registro
    function registration() {
        return view('registration');
    }

    // Valida los datos de registro utilizando la clase RegstrationRequest y crea el usuario nuevo
    function validateRegistration(RegistrationRequest $request) {
        $data = $request->all();

        User::create([
            'name'      =>  $data['name'],
            'email'     =>  $data['email'],
            'password'  =>  Hash::make($data['password'])
        ]);

        return redirect('login')->with('success', 'Registration completed');
    }

    // Valida los datos de login mediante la clase LoginRequest e inicia la sesión si las credenciales son correctas
    function validateLogin(LoginRequest $request) {
        $credentials = $request->only('email', 'password');

        if(Auth::attempt($credentials)) {
            if(User::where('email', $request->email)->first()->ban) {
                return back()->with('error', 'Your account was banned! Please contact the administrators.');
            }
            return redirect('/');
        }
        // Por seguridad, no se especifica si el error está en el email o en la contraseña
        return redirect('login')->with('error', 'Email or password incorrect');
    }

    // Cierra la sesión del usuario
    function logout() {
        Session::flush();

        Auth::logout();

        return redirect('login');
    }
}
