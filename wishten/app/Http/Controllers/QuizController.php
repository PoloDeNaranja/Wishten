<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;
use App\Models\Question;
use App\Models\Answer;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\QuestionRequest;
use App\Http\Requests\AnswerRequest;



class QuizController extends Controller
{
    function addQuiz(Request $request) {
        $video = Video::find($request['video']);

        // Si el usuario no está autorizado para editar el video, se le deniega el acceso
        if(Auth::user()->cannot('update', $video)) {
            abort(403);
        }

        return view('addQuiz')->with('video', $video);
    }

    // Crea una pregunta dentro de un video
    function addQuestion(Video $video, QuestionRequest $request) {
        if(Auth::user()->cannot('update', $video)) {
            abort(403);
        }
        $video->questions()->create([
            'text'          =>  $request->question_text,
            'question_time' =>  $request->minute
        ]);
        return back()->with('success', 'The new question was added to your video successfully');
    }

    // Añade una opción de respuesta para una pregunta
    function addAnswer(Question $question, AnswerRequest $request) {
        if(Auth::user()->cannot('update', $question->video)) {
            abort(403);
        }
        $question->answers()->create([
            'text'  =>  $request->answer_text
        ]);
        return back()->with('success', 'The new answer was added to your video successfully');
    }

    // Elimina una pregunta dentro de un video
    function removeQuestion(Question $question) {
        if(Auth::user()->cannot('delete', $question->video)) {
            abort(403);
        }
        $question->delete();
        return back()->with('success', 'Question deleted successfully');
    }

    // Elimina una opción de respuesta para una pregunta
    function removeAnswer(Answer $answer) {
        if(Auth::user()->cannot('delete', $answer->question->video)) {
            abort(403);
        }
        //
    }
}
