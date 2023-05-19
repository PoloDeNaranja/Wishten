@extends('layouts.app')

@section('title', 'Videos')

@section('content')
@include('layouts.messages')

    <form action="{{ route('video.filter')}}" method="post">
        @csrf
        <label for="subject_name">
            <input type="text" placeholder="Filter by subject" name="subject_name" list="subject_names">
            <datalist id="subject_names">
                @foreach ($subjects as $subject)
                    <option value="{{ $subject->name }}"></option>
                @endforeach
            </datalist>
        </label>
    </form>

    @if (!$videos || $videos->isEmpty())
        <h1>No videos</h1>
    @else
        @foreach ($videos as $video)
            <a href="{{ route('video.watch', ['video'=>$video->id]) }}">{{ $video->title }}</a>
        @endforeach

    @endif




@endsection
