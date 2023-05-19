@extends('layouts.app')

@section('title', 'Videos')

@section('content')
@include('layouts.messages')

    @if (!$videos->isEmpty())
        @foreach ($videos as $video)
            <a href="{{ route('video.watch', ['video'=>$video->id]) }}">{{ $video->title }}</a>
        @endforeach
    @else
        <h1>No videos yet</h1>
    @endif

    {{-- <form action="{{ route('video.filter', ['subject'=>$])}}" method="post">
        <select name="subject" id="subject">
            @foreach ($ as )

            @endforeach
          </select>
    </form> --}}


@endsection
