


@extends('layouts.app')

@section('title', 'My Offers')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ url('/css/offerListStyle.css') }}">
@endsection
@section('js')
    <script async src="{{ url('/js/popup.js') }}"></script>
@endsection

@section('content')
@include('layouts.messages')

<h1>My Offers</h1>

 {{-- <form class="search-bar" action="{{ route('my-offers')}}" method="get">
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
</form>  --}}

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
                <span class="description-label">Description:</span>
                <span class="openPopup link" title="View description"><i class="fa-regular fa-eye"></i> View</span>
                {{--<span class="openPopup link">click to show</span>
                 <div class="popup">
                    <span class="closePopup">&times;</span>
                    <label for="description">
                        <textarea id="description" placeholder="Description of your offer" name="description" rows="4" cols="50" required>{{ $offer->description }}</textarea>
                    </label>
                </div> --}}
                <span class="salary-label">Vacants:</span>
                <span>{{ $offer->vacants }}</span>
                <span class="salary-label">Salary:</span>
                <span>{{ $offer->salary }}€</span>

            </div>
            <div class="buttons">
            @if (Auth::user()->role == 'admin' || Auth::user()->role == 'company')
            <a href="{{ route('offer.edit', ['offer'=>$offer->id]) }}"class="edit-button"> Edit Offer</a>
            @endif
            <a href="{{ url('storage/' . $offer->document_path) }}" class="view-button"> View Offer</a>
            <a href="{{ url('storage/' . $offer->document_path) }}" class="download-button" download>Download</a>
            <button class="button-chat" onclick>Chat</button>
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
