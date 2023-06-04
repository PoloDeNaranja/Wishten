@extends('layouts.app')

@section('title', 'Videos')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ url('/css/videoListStyle.css') }}" />
@endsection

@section('content')
@include('layouts.messages')

    <form class="search-bar" action="{{ route('videos')}}" method="get">
        @csrf
        <div>
            <label for="subject_name">
                <input class="search-input" type="text" placeholder="Filter by subject" name="subject_name" list="subject_names" @isset($subject_name) value="{{ $subject_name }}"@endif>
                <datalist id="subject_names">
                    @foreach ($subjects as $subject)
                        <option value="{{ $subject->name }}"></option>
                    @endforeach
                </datalist>
                <button class="search-button" type="submit">
                    <i class="fa-sharp fa-solid fa-magnifying-glass"></i>
                </button>
            </label>
        </div>
    </form>

    @if (!$videos || $videos->isEmpty())
        <h1>No videos</h1>
    @else
        <div class="video-list">
            @foreach ($videos as $video)
                <div class="video-card">
                    <img src="{{ url('storage/' . $video->thumb_path) }}" alt="{{ $video->title }}">
                    <a href="{{ route('video.watch', ['video'=>$video->id]) }}"></a>
                    <h3>{{ $video->title }}</h3>
                    <p>{{ $video->user->name }}</p>
                </div>
            @endforeach
        </div>
    @endif




@endsection
