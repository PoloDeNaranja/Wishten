@extends('layouts.app')

@section('title', 'Stats: '.$video->title)

@section('css')
<link rel="stylesheet" type="text/css" href="{{ url('/css/videoStatsStyle.css') }}">
@endsection

@section('js')
<script  src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
@endsection

@section('content')
@include('layouts.messages')

<h1>Stats for video '{{ $video->title }}'</h1>

<p>Views: {{ $video->views->count() }}</p>
<p>Favs: {{ $video->numberOfFavs() }}</p>
@if ($video->questions->count()>0)
    <h2>Quiz stats:</h2>
    @foreach ($video->questions->sortBy('question_time') as $question)
        <h3>{{ $question->text }}</h3>
        <div style="width:100%;max-width:600px">
            <canvas id="answers-{{ $question->id }}" ></canvas>
        </div>
    <script>
        // script basado en https://www.w3schools.com/js/js_graphics_chartjs.asp
        const answers{{ $question->id }} = [
            @foreach ($question->answers as $answer)
            "{{ preg_replace('/[\']/', '', $answer->text)}} @if($answer->is_correct)[CORRECT] @endif",
            @endforeach];
        const users{{ $question->id }} = [@foreach ($question->answers as $answer)"{{ $answer->users->count() }}",@endforeach];
        const colors{{ $question->id }} = [
          "#b91d47",
          "#00aba9",
          "#2b5797",
          "#e8c3b9",
          "#1e7145"
        ];

        new Chart("answers-{{ $question->id }}", {
          type: "doughnut",
          data: {
            labels: answers{{ $question->id }},
            datasets: [{
              backgroundColor: colors{{ $question->id }},
              data: users{{ $question->id }}
            }]
          },
          options: {
            title: {
              display: true,
              text: "Answers for question: {{ preg_replace('/[\']/', '', $question->text) }}"
            }
          }
        });
        </script>

    @endforeach

@endif
@endsection
