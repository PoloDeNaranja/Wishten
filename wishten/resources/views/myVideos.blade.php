@extends('layouts.app')

@section('title', 'My Videos')

@section('content')

    @foreach ($videos as $video)
        <a href="{{ route('video.watch', $video->id) }}">{{ $video->title }}</a>

    @endforeach

@endsection
