@extends('layouts.app')

@section('title', 'Chat')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ url('/css/chatStyle.css') }}">
@endsection

@section('js')
    <script async src="{{ url('/js/scrollbar.js') }}"></script>
@endsection

@section('content')
    @include('layouts.messages')

    <div id="chat-content">
        <ul id="message-list">
            @foreach($conversation->messages()->orderBy('date')->get() as $message)
               
            <li class="{{ ($message->id_sender === Auth::id())}}">
                <div class="message-header">
                    <strong>{{ $message->sender->name }}</strong>
                </div>
                <div class="message-content">
                        {{ $message->content }}
                </div>
                <div class="message-date">
                    {{ date( "F d, Y - H:i", strtotime($message->date)) }}
            </div>
            </li>
            @endforeach
        </ul>
    </div>


        <div id="input-content">
            <form class="A" action="{{ route('chat.send_message', ['conversation' => $conversation->id]) }}" method="post">
            @csrf
                <input type="text" name ="message" id="message-input" placeholder="Type your message">

                    <button class="button" type="submit">Send</button>
            </form>
        </div>


@endsection


