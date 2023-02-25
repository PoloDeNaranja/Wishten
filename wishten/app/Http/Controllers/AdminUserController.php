<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    function index() {
        return view('adminUsers');
    }
}
