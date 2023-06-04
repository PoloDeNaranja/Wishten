@extends('layouts.app')

@section('title', $video->title)

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ url('/css/videoWatchStyle.css') }}" />
@endsection

@section('content')

<div class="video-display">
    <div class="video-view">
        @if (Auth::id() == $video->owner_id)
            <a class="button" href="{{ route('video.edit', ['video'=>$video->id]) }}">
                <i class="fa-regular fa-pen-to-square"></i>
                Edit
            </a>
        @endif
        <video controls src="{{ url('storage/'.$video->video_path) }}"></video>
        <div class="video-info">
            <h3 class="video-title">{{ $video->title }}</h3>
            <a class="video-subject" href="videos?subject_name={{ $video->subject->name }}">{{ $video->subject->name }}</a>
            <p class="video-desc">{{ $video->description }}</p>
        </div>
    </div>
    <div class="related-videos">
        @foreach ($video->subject->videos as $related_video)
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
