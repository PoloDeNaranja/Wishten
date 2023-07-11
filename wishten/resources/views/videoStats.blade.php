@extends('layouts.app')

@section('title', 'Stats: '.$video->title)


@section('content')
@include('layouts.messages')

<h1>Stats for video '{{ $video->title }}'</h1>

<p>Views: {{ $video->views->count() }}</p>
<p>Favs: {{ $video->numberOfFavs() }}</p>
@if ($video->questions->count()>0)
    <h2>Quiz stats:</h2>
    @foreach ($video->questions->sortBy('question_time') as $question)
        <h3>{{ $question->text }}</h3>
        @foreach ($question->answers as $answer)
            <p>{{ $answer->text }}: {{ $answer->users->count() }}</p>
        @endforeach
    @endforeach
@endif
@endsection
