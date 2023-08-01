@extends('layouts.app')

@section('title', 'My Videos')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ url('/css/videoListStyle.css') }}" />
@endsection

@section('content')
    @include('layouts.messages')
    <h1>My Videos</h1>

    <form class="search-bar" action="{{ route('my-videos')}}" method="get">
        @csrf
        <div>
            <label for="video_title">
                <input class="search-input" type="text" placeholder="Filter by title" name="video_title" list="video_titles" @isset($video_title) value="{{ $video_title }}"@endif>
                <datalist id="video_titles">
                    @foreach ($videos as $video)
                        <option value="{{ $video->title }}"></option>
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
        <div class="my-video-list">
            @foreach ($videos as $video)
                <div class="video-card">
                    <img src="{{ url('storage/' . $video->thumb_path) }}" alt="{{ $video->title }}">
                    <a href="{{ route('video.edit', ['video'=>$video->id]) }}"></a>
                    <div class="video-info">

                        <h3>{{ $video->title }}
                            @if ($video->status === 'pending')
                                <i class="fa-solid fa-triangle-exclamation fa-xl" style="color: #CB9957;" title="This video is being revised"></i>
                            @elseif ($video->status === 'blocked')
                                <i class="fa-solid fa-triangle-exclamation fa-xl" style="color: #CB5763;" title="This video is blocked"></i>
                            @endif
                        </h3>
                        <h4>{{ $video->subject->name }}</h4>
                        <p>{{ $video->description }}</p>


                    </div>


                </div>

            @endforeach
        </div>
    @endif


@endsection
