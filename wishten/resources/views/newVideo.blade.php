@extends('layouts.app')

@section('title', 'New Video')

@section('content')

@include('layouts.messages')

<form action="{{ route('video.upload', Auth::id()) }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="text" placeholder="Title of your video" name="title" required>
    <input type="text" placeholder="Description of your video" name="description" required>
    <input type="file" name="video" id="video" required>
    <button type="submit">Upload Video</button>
</form>


@endsection
