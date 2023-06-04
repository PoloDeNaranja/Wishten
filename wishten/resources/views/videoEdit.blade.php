@extends('layouts.app')

@section('title', $video->title)

@section('content')

<video width="320" height="240" controls src="{{ url('storage/'.$video->video_path) }}"></video>
<p>{{ $video->description }}</p>
<form action="{{ route('video.delete', ['video' => $video->id, 'admin' => 0]) }}" method="post">
    @csrf
    <button type="submit">Delete</button>
</form>
@endsection
