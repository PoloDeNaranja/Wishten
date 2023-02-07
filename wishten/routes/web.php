<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    return view('home');
});

Route::controller(AuthController::class)->group(function(){

    Route::get('login', 'index')->name('login');

    Route::get('registration', 'registration')->name('registration');

    Route::get('logout', 'logout')->name('logout');

    Route::post('validate_registration', 'validate_registration')->name('auth.validate_registration');

    Route::post('validate_login', 'validate_login')->name('auth.validate_login');

});

Route::controller(UserController::class)->group(function(){

    Route::get('profile', 'index')->name('profile');

    Route::get('privacy-security', 'privacy_security')->name('privacy-security');

    Route::post('update_pic', 'update_pic')->name('profile.update_pic');

    Route::post('update_info', 'update_info')->name('profile.update_info');

    Route::post('delete_pic', 'delete_pic')->name('profile.delete_pic');

    Route::post('change_password', 'change_password')->name('profile.change_password');

});


