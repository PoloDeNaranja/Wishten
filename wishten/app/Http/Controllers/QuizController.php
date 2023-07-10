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
        if($question->answers->isEmpty()) {
            // la primera respuesta añadida se pone correcta por defecto
            $question->answers()->create([
                'text'          =>  $request->answer_text,
                'is_correct'    =>  1
            ]);
        }
        else {
            $question->answers()->create([
                'text'  =>  $request->answer_text
            ]);
        }
        return back()->with('success', 'The new answer was added to your video successfully');
    }

    // Marca una respuesta como correcta, desmarcando la anterior
    function setCorrect(Answer $answer) {
        if(Auth::user()->cannot('update', $answer->question->video)) {
            abort(403);
        }
        if($answer->is_correct) {
            return back();
        }
        $old_correct = $answer->question->answers->where('is_correct', 1)->first();
        $old_correct->update([
            'is_correct'    =>  0
        ]);
        $answer->update([
            'is_correct'    =>  1
        ]);
        return back()->with('success', 'The answer was marked as correct');
    }

    function storeResults(Video $video, Request $request) {
        if(!$request->get('selected_answer')) {
            return back();
        }
        $correct_answers = 0;
        foreach($request->get('selected_answer')  as $answer_id) {
            $answer = Answer::find($answer_id);
            $old_answer = Auth::user()->hasAnswered($answer->question);
            // Se reemplaza la respuesta dada por el usuario en caso de haber respondido previamente
            if($old_answer != false) {
                Auth::user()->answers_given()->detach($old_answer->id);
            }
            Auth::user()->answers_given()->attach($answer, ['date'=>date("Y-m-d H:i:s")]);
            // Almacenamos el número de respuestas correctas en la tabla de visualizaciones
            if($answer->is_correct == 1) {
                $correct_answers++;
            }
        }
        $video->views()->where('user_id', Auth::user()->id)->update(['correct_answers'=>$correct_answers]);
        $video->save();
        return back()->with('success', 'Your results were stored correctly');

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
        // Si la respuesta era correcta, se marca como correcta otra cualquiera dentro de las respuestas para esa pregunta
        if($answer->is_correct) {
            $answer->question->answers->where('id','!=', $answer->id)->first()->update([
                'is_correct'    =>  1
            ]);
        }
        $answer->delete();
        return back()->with('success', 'Answer deleted successfully');
    }
}
