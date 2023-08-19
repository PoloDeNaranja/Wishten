@extends('layouts.app')

@section('title', 'Offers Home')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ url('/css/offerListStyle.css') }}">
@endsection

@section('content')
    @include('layouts.messages')

    <div class="top-buttons">

        @if (Auth::user()->role == 'company' || Auth::user()->role == 'admin' )
        <a href="{{ route('my-offers') }}" class="button-offers">My offers</a>   
        @endif
        @if (Auth::user()->role == 'admin' || Auth::user()->role == 'company')
        <a href="{{ route('new-offer') }}" class="button-add">Upload Offer</a>
        @endif

    </div>
    


    <form class="search-bar" action="{{ route('offer.results')}}" method="get">
        @csrf
        <div>
            <label for="offer_title">
                <input class="search-input" type="text" placeholder="Filter by title" name="offer_title" list="offer_titles" @isset($offer_title) value="{{ $offer_title }}"@endif>
                <datalist id="offer_titles">
                    @foreach ($offers as $offer)
                        <option value="{{ $offer->title }}"></option>
                    @endforeach
                </datalist>
                <button class="search-button" type="submit">
                    <i class="fa-sharp fa-solid fa-magnifying-glass"></i>
                </button>
            </label>
        </div>
    </form>




<h3>Internship offers</h3>
@if (!$offers || $offers->isEmpty())
<h1>No offers available</h1>
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
                
                <button class="button-chat" onclick>Chat</button>
            </div>
        </div>
       
       
       
       
       
    @endforeach  
    </div>
@endif






@endsection
