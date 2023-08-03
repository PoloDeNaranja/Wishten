@extends('layouts.app')

@section('title', 'Home')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ url('/css/homeStyle.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('/css/videoListStyle.css') }}">
@endsection

@section('content')
    @include('layouts.messages')

    <form class="search-bar" action="{{ route('video.results') }}" method="get">
        @csrf
        <div>
            <div>
                <input class="search-input" id="subject_name" type="text" placeholder="Filter by subject" name="subject_name"
                    list="subject_names"
                    @isset($subject_name) value="{{ $subject_name }}"@endif>
            <datalist id="subject_names">
                @foreach ($subjects as $subject)
                    <option value="{{ $subject->name }}"></option>
                @endforeach
            </datalist>
            <button class="search-button" type="submit">
                <i class="fa-sharp fa-solid fa-magnifying-glass"></i>
            </button>
        </div>
    </div>
</form>

<h3>Most viewed videos</h3>
@if (!$videos_by_views || $videos_by_views->isEmpty())
    <h1>No videos</h1>
@else
    <div class="video-list">
        @foreach ($videos_by_views as $video)
            <div class="video-card">
                <img src="{{ url('storage/' . $video->thumb_path) }}" alt="{{ $video->title }}">
                <a href="{{ route('video.watch', ['video' => $video->id]) }}"></a>
                <h3>{{ $video->title }}</h3>
                <p>{{ $video->user->name }}</p>
                <p> <i class="fa-solid fa-eye "></i> {{ $video->views->count() }}
                    <i class="fa-solid fa-heart "></i> {{ $video->numberOfFavs() }}
                </p>

            </div>
        @endforeach
    </div>
@endif

<h3>Users favourite videos</h3>

@if (!$videos_by_favs || $videos_by_favs->isEmpty())
    <h1>No videos</h1>
@else
    <div class="video-list">
        @foreach ($videos_by_favs as $video)
            <div class="video-card">
                <img src="{{ url('storage/' . $video->thumb_path) }}" alt="{{ $video->title }}">
                <a href="{{ route('video.watch', ['video' => $video->id]) }}"></a>
                <h3>{{ $video->title }}</h3>
                <p>{{ $video->user->name }}</p>
                <p> <i class="fa-solid fa-eye "></i> {{ $video->views->count() }}
                    <i class="fa-solid fa-heart "></i> {{ $video->numberOfFavs() }}
                </p>
            </div>
        @endforeach
    </div>
@endif

<h3>Interactive videos</h3>
@if (!$video_quizzes || $video_quizzes->isEmpty())
    <h1>No videos</h1>
@else
    <div class="video-list">
        @foreach ($video_quizzes as $video)
            <div class="video-card">
                <img src="{{ url('storage/' . $video->thumb_path) }}" alt="{{ $video->title }}">
                <a href="{{ route('video.watch', ['video' => $video->id]) }}"></a>
                <h3>{{ $video->title }}</h3>
                <p>{{ $video->user->name }}</p>
                <p> <i class="fa-solid fa-eye "></i> {{ $video->views->count() }}
                    <i class="fa-solid fa-heart "></i> {{ $video->numberOfFavs() }}
                </p>
            </div>
        @endforeach
    </div>
@endif
{{-- Por cada usuario al que sigue, se muestran sus últimos vídeos subidos --}}
@foreach (Auth::user()->followed_users()->get() as $followed_user)
    @php($videos = $followed_user->videos()->latest()->get())
    @if ($videos->count() > 0)
    <h3>{{ $followed_user->name }}'s latest videos</h3>
    <div class="video-list">
        @foreach ($videos as $video)
            <div class="video-card">
                <img src="{{ url('storage/' . $video->thumb_path) }}" alt="{{ $video->title }}">
                <a href="{{ route('video.watch', ['video' => $video->id]) }}"></a>
                <h3>{{ $video->title }}</h3>
                <p>{{ $video->user->name }}</p>
                <p> <i class="fa-solid fa-eye "></i> {{ $video->views->count() }}
                    <i class="fa-solid fa-heart "></i> {{ $video->numberOfFavs() }}
                </p>
            </div>
        @endforeach
    </div>
    @endif
@endforeach


@endsection
