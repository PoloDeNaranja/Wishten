@extends('layouts.app')

@section('title', $video->title)

@section('css')
<link rel="stylesheet" type="text/css" href="{{ url('/css/videoWatchStyle.css') }}">
<link href="https://vjs.zencdn.net/8.5.2/video-js.css" rel="stylesheet" />
@endsection

@if ($video->questions->count()>0)
@section('js')
<script async src="{{ url('/js/showQuiz.js') }}"></script>
    <script async src="{{ url('/js/answerQuiz.js') }}"></script>
    <script async src="https://vjs.zencdn.net/8.5.2/video.min.js"></script>
@endsection
@endif

@section('content')
@include('layouts.messages')

<div class="video-display">
    <div class="action-buttons">
        @if (Auth::user()->can('update', $video))
            <a class="button" href="{{ route('video.edit', ['video'=>$video->id]) }}">
                <i class="fa-regular fa-pen-to-square"></i>
                Edit
            </a>
        @endif
        @if (Auth::user()->can('update', $video))
            <a class="button" href="{{ route('video.stats', ['video'=>$video->id]) }}">
                <i class="fa-solid fa-chart-line"></i>
                Stats
            </a>
        @endif
        <form action="{{ route('video.fav', ['video'=>$video->id, 'user'=>Auth::id()]) }}" method="post">
            @csrf
            <button class="button" type="submit"
                @if ($video->isFav(Auth::user()))
                    title="Remove from your favourite videos">
                    <i class="fa-solid fa-heart"></i>
                @else
                    title="Add to your favourite videos">
                    <i class="fa-regular fa-heart"></i>
                @endif
            </button>
        </form>
        <a class="video-link" href="results?subject_name={{ preg_replace('/[^A-Za-z0-9_\-]/', '+', $video->subject->name) }}"> Subject: {{ $video->subject->name }}</a>
    </div>
    <div class="video-view">

        <div id="video-wrapper">
            <video
            id="video-element"
            class="video-js"
            controls

            width="1000"
            height="auto"

            data-setup="{}"
            >
                <source src="{{ url('storage/'.$video->video_path) }}" type="video/mp4" />
                <p class="vjs-no-js">
                To view this video please enable JavaScript, and consider upgrading to a
                web browser that
                <a href="https://videojs.com/html5-video-support/" target="_blank"
                    >supports HTML5 video</a
                >
                </p>
            </video>


            {{-- <video controls src="{{ url('storage/'.$video->video_path) }}" id="video-element"></video> --}}
            <div id="questions">
                @php($count = 0)
                @foreach ($video->questions as $question)
                    <div id="question-{{ $question->id }}" class="question-wrapper" data-minute="{{ $question->question_time }}">
                        <p>{{ $question->text }}</p>
                        @if ($question->answers->count() > 0)
                        <div class="answer-list">
                            @foreach ($question->answers as $answer)
                                <label for="checkbox-{{ $answer->id }}">
                                    <input type="checkbox" class="answer-input" name="answer-{{ $count }}" id="checkbox-{{ $answer->id }}" value="{{ $answer->id }}" data-correct="{{ $answer->is_correct }}">{{ $answer->text }}
                                </label>
                            @endforeach
                        </div>
                        <button class="button answer-btn">Answer</button>
                        <button class="button continue">Continue</button>
                        @else
                        <button class="button continue show">Continue</button>
                        @endif

                    </div>
                    @php($count++)
                @endforeach
            </div>
        </div>
        <div class="video-info">
            <h3 class="video-title">{{ $video->title }}</h3>
            <a class="video-link-user" href="profile?user= {{ $video->owner_id }}"> <i class="fa-solid fa-user"></i> {{ $video->user->name }}</a>
            <p class="video-desc">{{ $video->description }}</p>
            <p>{{ $video->views()->count() }} views</p>
            <p>{{ date( "F d, Y", strtotime($video->created_at)) }}</p>

            @php($questions_count = $video->numberOfQuestions())
            @if ($questions_count > 0)
                <p>Last score: {{ $video->userScore(Auth::user()) }}% ({{ $video->score(Auth::user()) }}/{{ $questions_count }}) <i class="fa-solid fa-circle-info" title="The question will be correct only if ALL correct answers are given and NO incorrect answers are given"></i></p>
            @endif
        </div>


    </div>
    @if ($video->questions->count()>0)
        <form id="submit-answers" action="{{ route('quiz.store_results', $video->id) }}" method="post">
            @csrf
            <button class="button store" type="submit" title="Store your results">Store results</button>
        </form>
    @endif
    <div class="related-videos">
        @foreach ($video->subject->videos->where('status', 'valid') as $related_video)
            @if ($related_video->id != $video->id)
                <div class="video-card">
                    <img src="{{ url('storage/' . $related_video->thumb_path) }}" alt="{{ $related_video->title }}">
                    <a href="{{ route('video.watch', ['video'=>$related_video->id]) }}"></a>
                    <h3>{{ $related_video->title }}</h3>
                    <p>{{ $related_video->user->name }}</p>
                </div>
            @endif
        @endforeach
    </div>

</div>





@endsection
