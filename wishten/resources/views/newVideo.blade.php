@extends('layouts.app')

@section('title', 'New Video')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ url('/css/newVideoStyle.css') }}" />
@endsection

@section('content')

@include('layouts.messages')

<form action="{{ route('video.upload', Auth::id()) }}" method="POST" enctype="multipart/form-data">
    @csrf

    <label for="video">
        <i class="fa-solid fa-file-video fa-bounce fa-10x"></i>
        <input type="file" name="video" id="video" accept="video/*"required>
    </label>
    <label for="title">
        <input type="text" placeholder="Title of your video" name="title" required>
    </label>
    <label for="description">
        <textarea type="text" placeholder="Description of your video" name="description" rows="4" cols="50" required></textarea>
    </label>
    <button type="submit" class="button-upload">Upload Video</button>

</form>


@endsection
