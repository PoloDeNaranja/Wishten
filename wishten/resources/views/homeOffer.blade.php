@extends('layouts.app')

@section('title', 'Offers Home')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ url('/css/offerListStyle.css') }}">
@endsection

@section('js')
    <script async src="{{ url('/js/popup.js') }}"></script>
@endsection

@section('content')
    @include('layouts.messages')

    <div class="top-buttons">

        @if (Auth::user()->role == 'company' || Auth::user()->role == 'admin' )
        <a href="{{ route('my-offers') }}" class="button">My offers</a>
        @endif
        @if (Auth::user()->role == 'admin' || Auth::user()->role == 'company')
        <a href="{{ route('new-offer') }}" class="button">Upload Offer</a>
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
            <div class="offer-info">
                <span class="description-label">Description:</span>
                <span class="openPopup link" title="View description"><i class="fa-regular fa-eye"></i> View</span>

                <span class="salary-label">Vacants:</span>
                <span>{{ $offer->vacants }}</span>
                <span class="salary-label">Salary:</span>
                <span>{{ $offer->salary }}€</span>

            </div>
            <div class="buttons">
            <!-- Tengo que poner lo del update para el owner-->
            @if (Auth::user()->can('update', $offer))
            <a href="{{ route('offer.edit', ['offer'=>$offer->id]) }}"class="button"> Edit Offer</a>
            @endif
            <a href="{{ url('storage/' . $offer->document_path) }}" class="button"> View Offer</a>
            <a href="{{ url('storage/' . $offer->document_path) }}" class="button" download>Download</a>
            <button class="button" onclick>Chat</button>
            </div>
        </div>



        <div class="popup">
            <span class="closePopup">&times;</span>
            <h3>{{ $offer->title }}</h3>
            <p readonly class="description">{{ $offer->description }}</p>
        </div>

    @endforeach
    </div>
@endif






@endsection
