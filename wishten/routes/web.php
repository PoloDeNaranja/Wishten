<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\OfferController;

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
Route::controller(HomeController::class)->group(function(){

    Route::get('/', 'home')->name('home');


});

//Ruta de tutoriales
Route::view('/tutorials', 'homeGuest');

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

        Route::get('followers', 'listFollowers')->name('followers');

        Route::get('followed', 'listFollowed')->name('followed');

        Route::post('update_pic/{user}', 'updatePic')->name('profile.update_pic');

        Route::post('update_info/{user}', 'updateInfo')->name('profile.update_info');

        Route::post('delete_pic/{user}', 'deletePic')->name('profile.delete_pic');

        Route::post('change_password/{user}', 'changePassword')->name('profile.change_password');

        Route::post('delete_user/{user}', 'delete')->name('user.delete');

        Route::post('follow/{user}', 'follow')->name('user.follow');

    });

    // Rutas de gestión de vídeos
    Route::controller(VideoController::class)->group(function(){

        // Route::get('videos', 'index')->name('videos');
        Route::get('results', 'results')->name('video.results');

        Route::get('most-viewed', 'mostViewed')->name('video.most-viewed');

        Route::get('most-favs', 'mostFavs')->name('video.most-favs');

        Route::get('interactive', 'interactive')->name('video.interactive');

        Route::get('user-videos', 'userVideos')->name('video.user-videos');

        Route::get('watch', 'watch')->name('video.watch');

        Route::get('edit', 'edit')->name('video.edit');

        Route::get('stats', 'stats')->name('video.stats');

        Route::get('new-video', 'newVideo')->name('new-video');

        Route::get('my-videos', 'myVideos')->name('my-videos');

        Route::get('fav-videos', 'favVideos')->name('fav-videos');

        Route::post('upload/{user}', 'upload')->name('video.upload');

        Route::post('delete_vid/{video}/{admin}', 'delete')->name('video.delete');

        Route::post('set_title/{video}', 'setTitle')->name('video.set_title');

        Route::post('set_desc/{video}', 'setDesc')->name('video.set_desc');

        Route::post('set_subject/{video}', 'setSubject')->name('video.set_subject');

        Route::post('set_thumbnail/{video}', 'setThumbnail')->name('video.set_thumbnail');

        Route::post('fav/{video}/{user}', 'fav')->name('video.fav');

    });

    // Rutas de gestión de cuestionarios
    Route::controller(QuizController::class)->group(function(){

        Route::get('add-quiz/', 'addQuiz')->name('quiz.add_quiz');

        Route::post('add-question/{video}', 'addQuestion')->name('quiz.add_question');

        Route::post('add-answer/{question}', 'addAnswer')->name('quiz.add_answer');

        Route::post('set-correct/{answer}', 'setCorrect')->name('quiz.set_correct');

        Route::post('remove-question/{question}', 'removeQuestion')->name('quiz.remove_question');

        Route::post('remove-answer/{answer}', 'removeAnswer')->name('quiz.remove_answer');

        Route::post('store-results/{video}', 'storeResults')->name('quiz.store_results');

    });

    // Rutas de gestión de ofertas
    Route::controller(OfferController::class)->group(function(){


        Route::get('Offer-Results', 'OfferResults')->name('offer.results');

        Route::get('/OfferHome', 'home2')->name('home-2');

        Route::get('/download-document/{document}', 'downloadOffer')->name('offer.download');

        Route::get('my-offers', 'myOffers')->name('my-offers');

        Route::post('uploadOffer/{user}', 'uploadOffer')->name('offer.upload');

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

        Route::post('addUser', 'addUser')->name('adminUsers.addUser');

        Route::post('ban/{user}', 'ban')->name('adminUsers.ban');

        Route::post('changeRole/{user}', 'changeRole')->name('adminUsers.changeRole');

        Route::post('setPassword/{user}', 'setPassword')->name('adminUsers.setPassword');

    });

    // Administración de videos
    Route::controller(VideoController::class)->group(function(){

        Route::get('adminVideos', 'adminVideos')->name('adminVideos');

        Route::post('set_status/{video}', 'setStatus')->name('video.set_status');

    });

    //Administración de ofertas
    Route::controller(OfferController::class)->group(function(){

        Route::get('adminOffers', 'adminOffers')->name('adminOffers');


    });
});


// Rutas de ofertas, para ello debes ser company
Route::middleware('auth', 'roles:admin,company')->group(function () {

    // Página de offers si eres company que muestra el boton de aniadir offer
    Route::get('offer_company', function(){
        return view('offer_company');
    });

    // rutas de offers
    Route::controller(OfferController::class)->group(function(){

        Route::get('new-offer', 'newOffer')->name('new-offer');

        Route::post('delete_of/{offer}/{admin}', 'deleteOffer')->name('offer.delete');

        Route::post('uploadOffer/{user}', 'uploadOffer')->name('offer.upload');

        Route::post('set_title_offer/{offer}', 'setTitleOffer')->name('offer.set_title');

        Route::post('set_salary_offer/{offer}', 'setSalaryOffer')->name('offer.set_salary');

        Route::post('set_desc_offer/{offer}', 'setDescOffer')->name('offer.set_desc');

        Route::post('set_vacants_offer/{offer}', 'setVacantsOffer')->name('offer.set_vacants');

        Route::get('editOffer', 'editOffer')->name('offer.edit');





    });


});




Route::controller(ChatController::class)->group(function(){
    Route::get('/chat', 'ChatController@index');
    Route::post('/send-message', 'ChatController@sendMessage');
    Route::get('/get-messages', 'ChatController@getMessages');

});



