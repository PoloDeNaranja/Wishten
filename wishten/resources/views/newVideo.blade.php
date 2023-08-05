@extends('layouts.app')

@section('title', 'New Video')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ url('/css/newVideoStyle.css') }}">
@endsection

@section('js')
<script async src="{{ url('/js/validateInputs.js') }}"></script>
@endsection

@section('content')

@include('layouts.messages')
<h1>Upload your video!</h1>

<form action="{{ route('video.upload', Auth::id()) }}" method="POST" enctype="multipart/form-data">
    @csrf

    <label for="video" title="Select your video file">
        <i id="video-icon" class="fa-solid fa-file-video fa-bounce fa-5x"></i>
        <input type="file" name="video" id="video" accept="video/*" required>
    </label>

    <label for="title">
        <input type="text" placeholder="Title of your video" name="title" id="title" required>
    </label>
    <label for="description">
        <textarea placeholder="Description of your video" name="description" rows="4" cols="50" id="description" required></textarea>
    </label>
    <label for="subject_name">
        <input type="text" placeholder="Subject of your video" name="subject_name" id="subject_name" list="subject_names" required>
        <datalist id="subject_names">
            @foreach ($subjects as $subject)
                <option value="{{ $subject->name }}"></option>
            @endforeach
        </datalist>
    </label>
    <label for="thumbnail">
        <i id="thumbnail-icon" class="fa-sharp fa-solid fa-images fa-5x" title="Select an image for a thumbnail"></i>
        <input type="file" name="thumbnail" id="thumbnail" accept=".jpg,.jpeg,.png" required>
    </label>
    <button type="submit" class="button-upload">Upload Video</button>

</form>


@endsection
