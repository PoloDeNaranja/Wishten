@extends('layouts.app')

@section('title', 'New Offer')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ url('/css/newOfferStyle.css') }}">
@endsection

@section('js')
<script async src="{{ url('/js/validateInputs.js') }}"></script>
@endsection

@section('content')

@include('layouts.messages')
<h1>Upload your offer!</h1>

<form action="{{ route('offer.upload', Auth::id()) }}" method="POST" enctype="multipart/form-data">
    @csrf

    <label for="offer" title="Select your offer file">
    
        <i id="offer-icon" class="fa-solid fa-file fa-bounce fa-5x"></i> <!-- El fa-bounce fa-5x es para que de ese efecto de rebote hacia arriba -->
        <input type="file" name="offer" id="offer" accept="offer/*" required>
    </label>

    <label for="title">
        <input type="text" placeholder="Title of your offer" name="title" id="title" required>
    </label>
    <label for="description">
        <textarea placeholder="Description of your offer" name="description" rows="4" cols="50" id="description" required></textarea>
    </label>
    <label for="vacants">
        Vacants:
        <input type="number" name="vacants" id="vacants" min="0" required>
    </label>
    <label for="salary">
        Salary:
        <input type="number" name="salary" id="salary" min="0" step="100" required>
        <span>&euro;</span>
    </label>
    <button type="submit" class="button-upload">Upload Offer</button>

</form>


@endsection
