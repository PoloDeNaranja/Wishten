<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;
use App\Models\Subject;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;



class HomeController extends Controller
{
    // Función que muestra la vista de inicio
    function home() {
        // Si el usuario no ha iniciado sesión, se le muestra la vista de invitado
        if(Auth::guest()) {
            return view('homeGuest');
        }
        $subjects = Subject::all()->sortBy('name');
        // Vídeos ordenados por número de visitas
        $videos_by_views = Video::withCount('views')
                                ->orderBy('views_count', 'DESC')
                                ->latest()->take(5)->get();
        // Vídeos ordenados por número de favoritos
        $videos_by_favs = Video::withCount(['views'  => function (Builder $query) {
                                            $query->where('fav', 1);
                                }])->orderBy('views_count', 'DESC')
                                ->latest()->take(5)->get();
        // Vídeos que contienen por lo menos un cuestionario/anotación
        $video_quizzes = Video::withCount('questions')
                                ->having('questions_count', '>', 0)
                                ->latest()->take(5)->get();

        return view('home')->with([
            'videos_by_views'    =>  $videos_by_views,
            'videos_by_favs'    =>  $videos_by_favs,
            'video_quizzes'    =>  $video_quizzes,
            'subjects'  =>  $subjects
        ]);
    }

    
}
