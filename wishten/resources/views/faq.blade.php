@extends('layouts.app')

@section('title', 'About us')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ url('/css/faqStyle.css') }}" />
@endsection

@section('content')
    @include('layouts.messages')

    <div class="container">

        <div class="videos">
            <h2>Videos</h2>
            <div class="card">
                <h3>Where can I record the video?</h3>
                <p>Sorry but you can not record the video in Wishten, you have to use other tools</p>
            </div>
            <div class="card">
                <h3>Can I add a comments to the videos?</h3>
                <p>No, you can only give them like</p>
            </div>
        </div>

        <div class="offers">
            <h2>Offers</h2>
            <div class="card">
                <h3>Can I upload any kind of file?</h3>
                <p>No, but do not worry, the allowed files will appear on your desktop. </p>
            </div>
            <div class="card">
                <h3>Can I chat with other users?</h3>
                <p>You can only chat to the companies that have posted the offers. </p>
            </div>
        </div>

    </div>








@endsection