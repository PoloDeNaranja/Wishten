
    
        
@extends('layouts.app')

@section('title', Offers)

@section('css')
<link rel="stylesheet" type="text/css" href="{{ url('/css/offersListStyle.css') }}">
@endsection

@section('content')
@include('layouts.messages')

<h1>My Offers</h1>

<form class="search-bar" action="{{ route('my-offers')}}" method="get">
        @csrf
        <div>
            <label for="offer_title">
                <input class="search-input" type="text" placeholder="Filter by title" name="offer_title" list="offer_titles" @isset($offer_title) value="{{ $offer_title }}"@endif>
                <datalist id="offer_titles">
                    @foreach ($offers as $offer)
                        <option value="{{ $offer->title }}"></option>
                    @endforeach
                </datalist>
                <label for="offer_salary">
                <input class="search-input" type="number" placeholder="Filter by salary" name="offer_salary" @isset($offer_salary) value="{{ $offer_salary }}" @endif>
                </label>
                <button class="search-button" type="submit">
                    <i class="fa-sharp fa-solid fa-magnifying-glass"></i>
                </button>
            </label>
        </div>
</form>



@if (!$offers || $offers->isEmpty())
<h1>No offers</h1>

@else

    <div class="my-offer-list">
    @foreach ($offers as $offer)
        <div class="offer-card">
            <div class="name">{{ $offer->title }}</div>
            <div class="stats">
                <span>{{ $offer->vacants }}</span>
                <span>{{ $offer->salary }}</span>
            </div>
            <div class="buttons">
                <a class="button-download" href="{{ route('download.document', ['document' => $offer->document_path]) }}" download>Download</a>
                <button class="button-chat" onclick>Chat</button>
            </div>
        </div>
       
       
       
       
       
    @endforeach  
    </div>
@endif




@endsection