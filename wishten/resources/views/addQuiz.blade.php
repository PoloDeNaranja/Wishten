@extends('layouts.app')

@section('title', 'Add Quiz: ' . $video->title)

@section('css')
<link rel="stylesheet" type="text/css" href="{{ url('/css/addQuizStyle.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('/css/popupStyle.css') }}">

@endsection

@section('js')
<script async src="{{ url('/js/addInput.js') }}"></script>
    <script async src="{{ url('/js/popup.js') }}"></script>
@endsection

@section('content')
    @include('layouts.messages')

    <div class="video-display">
        <div class="video-view">
            <video controls src="{{ url('storage/' . $video->video_path) }}"></video>
        </div>
        <div class="questions-list">
            @foreach ($video->questions as $question)
                <h4 class="question-text">{{ $question->text }}</h4>
                @foreach ($question->answers as $answer)
                    <p class="answer-text">{{ $answer->text }}</p>
                @endforeach
                <form action="{{ route('quiz.add_answer', $answer->id) }}" method="post" class="add-answer">
                    <button class="button  add-answer-btn" type="button">New answer</button>
                </form>
            @endforeach
            <button class="button openPopup add-question">New question</button>
            <div class="popup PopupWindow">
                <div class="popupContent">
                    <span class="closePopup">&times;</span>
                    <h3>Add a new question</h3>
                </div>
            </div>
        </div>


    </div>

@endsection
