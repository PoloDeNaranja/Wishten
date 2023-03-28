@extends('layouts.app')

@section('title', $video->title)

@section('content')

<video width="320" height="240" controls src="{{ url('storage/'.$video->file_path) }}"></video>
<p>{{ $video->description }}</p>
@if (Auth::id() == $video->owner_id)
    <a href="{{ route('video.edit', ['video'=>$video->id]) }}">Edit</a>
@endif

@endsection