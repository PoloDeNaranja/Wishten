@extends('layouts.app')

@section('title', 'Edit: '.$offer->title)

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ url('/css/offerEditStyle.css') }}">
@endsection

@section('content')
@include('layouts.messages')


<div class="edit-info">
    <h2>Edit your Offer</h2>
        <form action="{{ route('offer.set_title', $offer->id) }}" method="post">
            @csrf
            <label for="title">Title:
                <input type="text" placeholder="Title of your offer" name="title" value="{{ $offer->title }}" id="title" required>
            </label>
            <button class="button apply" type="submit">
                <i class="fa-regular fa-circle-check fa-lg"></i>
            </button>
        </form>

        <form action="{{ route('offer.set_desc', $offer->id) }}" method="post">
            @csrf
            <label for="description">Description:
                <textarea id="description" placeholder="Description of your offer" name="description" rows="4" cols="50" required>{{ $offer->description }}</textarea>
            </label>
            <button class="button apply" type="submit">
                <i class="fa-regular fa-circle-check fa-lg"></i>
            </button>
        </form>

        <form action="{{ route('offer.set_salary', $offer->id) }}" method="post">
            @csrf
            <label for="salary">
                Salary:
                <input type="number" placeholder="Salary" name="salary" value="{{ $offer->salary }}" id="salary" min="0" step="100" required>
            </label>
            <button class="button apply" type="submit">
                <i class="fa-regular fa-circle-check fa-lg"></i>
            </button>
        </form>

        <form action="{{ route('offer.set_vacants', $offer->id) }}" method="post">
            @csrf
            <label for="vacants">
                Vacants:
                <input type="number" placeholder="Vacants" name="vacants" value="{{ $offer->vacants }}" id="vacants" min="0" required>
            </label>
            <button class="button apply" type="submit">
                <i class="fa-regular fa-circle-check fa-lg"></i>
            </button>
        </form>
           
        <form action="{{ route('offer.delete', ['offer' => $offer->id, 'admin' => 0]) }}" method="post">
            @csrf
            <button class="button red" type="submit">Delete</button>
        </form>
    
</div>

@endsection
