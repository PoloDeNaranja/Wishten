@extends('layouts.app')

@section('title', 'Add Quiz: ' . $video->title)

@section('css')
<link rel="stylesheet" type="text/css" href="{{ url('/css/addQuizStyle.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('/css/popupStyle.css') }}">

@endsection

@section('js')
<script async src="{{ url('/js/addInput.js') }}"></script>
    <script async src="{{ url('/js/popup.js') }}"></script>
    <script async src="{{ url('/js/getVideoTime.js') }}"></script>
@endsection

@section('content')
    @include('layouts.messages')

    <div class="video-display">
        <div class="video-view">
            <div class = "action-buttons">
            @if (Auth::user()->can('update', $video))
                <a class="button" href="{{ route('video.edit', ['video'=>$video->id]) }}">
                    <i class="fa-regular fa-pen-to-square"></i>
                    Edit
                </a>
            @endif
            <a class="button" href="{{ route('video.watch', ['video'=>$video->id]) }}">
                    <i class="fa-solid fa-eye"></i>
                    Watch
                </a>
                
            </div>
        <video controls src="{{ url('storage/' . $video->video_path) }}" id="video-element"></video>
        </div>
        <div class="questions-list">
            @if ($video->questions->isEmpty())
                <p>Add some quiz questions to your video to make it even more useful for your viewers!</p>
                <p>First, you may select the minute where you want to show the question in the progress bar. Then, you can add the answers or leave it blank to use that question as an annotation.</p>
            @endif
            @foreach ($video->questions->sortBy('question_time') as $question)
                <div class="quiz-header">
                    <h4 class="question-text">({{ $min = intval($question->question_time/60) }} : {{ $question->question_time - $min*60 }}) {{ $question->text }}</h4>
                    <form action="{{ route('quiz.remove_question', $question->id) }}" method="post">
                        @csrf
                        <button type="submit" class="remove-question" title="Remove this question">
                            <i class="fa-solid fa-circle-minus fa-xl"></i>
                        </button>
                    </form>
                </div>
                <div class="answers-list">
                    @foreach ($question->answers as $answer)
                    <div class="answer-row">
                            <form action="{{ route('quiz.remove_answer', $answer->id) }}" method="post">
                                @csrf
                                <button type="submit" class="remove-answer" title="Remove this answer">
                                    <i class="fa-solid fa-circle-minus"></i>
                                </button>
                            </form>
                            <form action="{{ route('quiz.set_correct', $answer->id) }}" method="post">
                                @csrf
                                <label class="answer-text @if($answer->is_correct) correct @endif" for="answer-{{ $answer->id }}" title="Mark this answer as correct">
                                    {{ $answer->text }}
                                </label>
                                <input type="submit" id="answer-{{ $answer->id }}" value="">
                            </form>
                        </div>
                    @endforeach
                </div>
                <form action="{{ route('quiz.add_answer', $question->id) }}" method="post" class="add-answer">
                    @csrf
                    <button class="button add-answer-btn" type="button" title="Add a new answer">
                        <i class="fa-solid fa-plus"></i>
                    </button>
                </form>
            @endforeach
            <button class="button openPopup" id="add-question" title="You may first select the minute in the video">New question</button>
            <div class="popup PopupWindow">
                <div class="popupContent">
                    <span class="closePopup">&times;</span>
                    <h3>Add a new question</h3>
                    <form action="{{ route('quiz.add_question', $video->id) }}" method="post" id="add-question-form">
                        @csrf
                        <p>Make sure you selected correctly the minute in the video!</p>
                        <textarea name="question_text"  cols="10" rows="3" required></textarea>
                        <button class="button-popup" type="submit">Add question</button>
                    </form>
                </div>
            </div>
        </div>


    </div>

@endsection
