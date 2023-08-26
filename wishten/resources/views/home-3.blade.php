@extends('layouts.app')

@section('title', 'Chat')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ url('/css/offerListStyle.css') }}">
@endsection

@section('js')
    <script async src="{{ url('/js/popup.js') }}"></script>
@endsection

@section('content')
    @include('layouts.messages')

    

    <div id="chat-content">
        <ul id="message-list">
            @foreach($conversation->messages()->orderBy('date&hour')->get() as $message)
            
                <li class="{{ ($message->id_sender === Auth::id())}}">
                    {{ $message->content }}
                </li>
            @endforeach
        </ul>
    </div>

 
        
        <form class="A" action="{{ route('chat.send_message', ['conversation' => $conversation->id]) }}" method="post">
        @csrf
            <input type="text" name ="message" id="message-input" placeholder="Type your message...">
            
                <button class="button" type="submit">Send</button>
            </form>
        
    

    
@endsection