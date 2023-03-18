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
    function index() {
        return view('login');
    }

    function registration() {
        return view('registration');
    }

    function validateRegistration(RegistrationRequest $request) {
        $data = $request->all();

        User::create([
            'name'      =>  $data['name'],
            'email'     =>  $data['email'],
            'password'  =>  Hash::make($data['password'])
        ]);

        return redirect('login')->with('success', 'Registration completed');
    }

    function validateLogin(LoginRequest $request) {
        $credentials = $request->only('email', 'password');

        if(User::where('email', $request->email)->first()->ban) {
            return back()->with('error', 'Your account was banned! Please contact the administrators.');
        }

        if(Auth::attempt($credentials)) {
            return redirect('/');
        }

        return redirect('login')->with('error', 'Email or password incorrect');
    }


    function logout() {
        Session::flush();

        Auth::logout();

        return redirect('login');
    }
}
