<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminUserController extends Controller
{
    function index() {
        $users = User::all();
        return view('adminUsers')->with('users', $users);
    }
}
