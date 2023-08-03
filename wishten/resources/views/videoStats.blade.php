@extends('layouts.app')

@section('title', 'Stats: '.$video->title)

@section('css')
<link rel="stylesheet" type="text/css" href="{{ url('/css/videoStatsStyle.css') }}">
@endsection


@section('content')
@include('layouts.messages')

<h1>Stats for video '{{ $video->title }}'</h1>
<div class="general-stats">
    <label title="Views">
        <i class="fa-solid fa-eye fa-xl"></i> {{ $video->views->count() }}
    </label>
    <label title="Favs">
        <i class="fa-solid fa-heart fa-xl"></i> {{ $video->numberOfFavs() }}
    </label>
</div>

@if ($video->numberOfQuestions()>0)
    <h2>Quiz stats:</h2>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    @foreach ($video->questions->sortBy('question_time') as $question)
        @if ($question->answers->count() > 0)


        <h3>{{ $question->text }}</h3>
        <div class="answers-chart" >
            <canvas id="{{ $question_charts[$question->id]->id }}" ></canvas>
        </div>


    <script>
        // script basado en https://www.codesolutionstuff.com/how-to-use-chart-js-in-laravel?expand_article=1
        var ctx = document.getElementById("{{ $question_charts[$question->id]->id }}").getContext('2d');
        var chart = new Chart("{{ $question_charts[$question->id]->id }}", {
            // Tipo de chart
            type: "doughnut",
            // Datos
            data: {
                labels:  {!!json_encode($question_charts[$question->id]->labels)!!} ,
                datasets: [
                    {
                        backgroundColor: {!! json_encode($question_charts[$question->id]->colors)!!} ,
                        data:  {!! json_encode($question_charts[$question->id]->dataset)!!}
                    }]
            },
            // Opciones
            options: {
                title: {
                    display: true,
                    text: "Answers for question: {{ preg_replace('/[\']/', '', $question->text) }}"
                }
            }
        });

    </script>
    @endif
    @endforeach
@else
<p>If you add some quiz questions in your video, you will see here the answers that users gave to your questions!</p>
@endif
@endsection
