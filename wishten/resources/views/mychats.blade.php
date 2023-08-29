@extends('layouts.app')

@section('title', 'ViewChats')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ url('/css/offerListStyle.css') }}">
@endsection

@section('js')
    <script async src="{{ url('/js/popup.js') }}"></script>
@endsection

@section('content')
    @include('layouts.messages')

    @if (!$chats || $chats->isEmpty())
    <h2>No chats</h2>
    @else

    <h2>Chats Available</h2>

    <div class="my-offer-list">
        @foreach ($chats as $chat)
            <div class="offer-card">
                <div class="name1">{{ $chat->offer->user->name}}</div>
                <div class="name2">{{ $chat->offer->title}}</div>
            
                <div class="buttons">
                
                    <a href="{{ route('home-3' , ['conversation' => $chat->id]) }}" class="button">Open chat</a>
                

                </div>
            </div>
        @endforeach
    </div>
    @endif
    

    
@endsection