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
            <video controls src="{{ url('storage/' . $video->video_path) }}" id="video-element"></video>
        </div>
        <div class="questions-list">
            @foreach ($video->questions as $question)
                <h4 class="question-text">{{ $question->text }} ({{ $min = intval($question->question_time/60) }} : {{ $question->question_time - $min*60 }})</h4>
                @foreach ($question->answers as $answer)
                    <p class="answer-text">{{ $answer->text }}</p>
                @endforeach
                <form action="{{ route('quiz.add_answer', $answer->id) }}" method="post" class="add-answer">
                    @csrf
                    <button class="button add-answer-btn" type="button">New answer</button>
                </form>
            @endforeach
            <button class="button openPopup" id="add-question">New question</button>
            <div class="popup PopupWindow">
                <div class="popupContent">
                    <span class="closePopup">&times;</span>
                    <h3>Add a new question</h3>
                    <form action="{{ route('quiz.add_question', $video->id) }}" method="post" id="add-question-form">
                        @csrf
                        <textarea name="question_text"  cols="10" rows="3" required></textarea>
                        <button class="button-popup" type="submit">Add question</button>
                    </form>
                </div>
            </div>
        </div>


    </div>

@endsection
