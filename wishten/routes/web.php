<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminUserController;

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

// Ruta de Home
Route::get('/', function () {
    return view('home');
});

// Rutas de Login y Registro
Route::controller(AuthController::class)->group(function(){

    Route::get('login', 'index')->name('login');

    Route::get('registration', 'registration')->name('registration');

    Route::get('logout', 'logout')->name('logout');

    Route::post('validate_registration', 'validateRegistration')->name('auth.validate_registration');

    Route::post('validate_login', 'validateLogin')->name('auth.validate_login');

});

// Rutas que requieren autenticación
Route::middleware('auth')->group(function () {

    // Rutas de Modificación de perfil
    Route::controller(UserController::class)->group(function(){

        Route::get('profile', 'index')->name('profile');

        Route::get('privacy-security', 'privacySecurity')->name('privacy-security');

        Route::post('update_pic/{user}', 'updatePic')->name('profile.update_pic');

        Route::post('update_info/{user}', 'updateInfo')->name('profile.update_info');

        Route::post('delete_pic/{user}', 'deletePic')->name('profile.delete_pic');

        Route::post('change_password/{user}', 'changePassword')->name('profile.change_password');

    });
});



// Rutas de Administración
Route::middleware('auth', 'roles:admin')->group(function () {

    // Página de administración general
    Route::get('admin', function(){
        return view('admin');
    });

    // Administración de usuarios
    Route::controller(UserController::class)->group(function(){

        Route::get('adminUsers', 'adminUsers')->name('adminUsers');

        Route::get('userInfo/{user}', 'userInfo')->name('userInfo');

    });
});

