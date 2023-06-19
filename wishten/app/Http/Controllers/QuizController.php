<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;
use App\Models\Question;
use App\Models\Answer;

class QuizController extends Controller
{
    // Crea una pregunta dentro de un video
    function addQuestion(Video $video, Request $request) {
        if(Auth::user()->cannot('update', $video)) {
            abort(403);
        }
        //
    }

    // Añade una opción de respuesta para una pregunta
    function addAnswer(Question $question, Request $request) {
        if(Auth::user()->cannot('update', $question->video)) {
            abort(403);
        }
        //
    }

    // Elimina una pregunta dentro de un video
    function removeQuestion(Question $question) {
        if(Auth::user()->cannot('delete', $question->video)) {
            abort(403);
        }
        //
    }

    // Elimina una opción de respuesta para una pregunta
    function removeAnswer(Answer $answer) {
        if(Auth::user()->cannot('delete', $answer->question->video)) {
            abort(403);
        }
        //
    }
}
