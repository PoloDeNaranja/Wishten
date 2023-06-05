@extends('layouts.app')

@section('title', $video->title)

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ url('/css/videoWatchStyle.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ url('/css/videoEditStyle.css') }}" />
@endsection

@section('content')

<div class="video-display">
    <div class="video-view">
        <video controls src="{{ url('storage/'.$video->video_path) }}"></video>
        <div class="edit-info">
            <h2>Edit your video</h2>
            <label for="title">Title:
                <input type="text" placeholder="Title of your video" name="title" value="{{ $video->title }}" required>
            </label>
            <label for="description">Description:
                <textarea type="text" placeholder="Description of your video" name="description" rows="4" cols="50" required>{{ $video->description }}</textarea>
            </label>
            <label for="subject_name">Subject:
                <input type="text" placeholder="Subject of your video" name="subject_name" list="subject_names" value="{{ $video->subject->name }}">
                <datalist id="subject_names">
                    @foreach ($subjects as $subject)
                        <option value="{{ $subject->name }}"></option>
                    @endforeach
                </datalist>
            </label>
            <label for="thumbnail" title="Select an image for a thumbnail">
                <img src="{{ url('storage/' . $video->thumb_path) }}" alt="{{ $video->title }}">
                <input type="file" name="thumbnail" id="thumbnail" accept=".jpg,.jpeg,.png" required>
            </label>
            <button class="button" type="submit">Apply changes</button>
            <form action="{{ route('video.delete', ['video' => $video->id, 'admin' => 0]) }}" method="post">
                @csrf
                <button class="button red" type="submit">Delete</button>
            </form>
            {{-- Add questions en caso de no tener e iría en un popup para no sobrecargar la vista --}}
        </div>
    </div>
</div>

@endsection
