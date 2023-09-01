@extends('layouts.app')

@section('title', 'About us')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ url('/css/aboutUsStyle.css') }}" />
@endsection

@section('content')
    @include('layouts.messages')

    <div class ="image-rectangle">
        <div class="image-overtext">
            <h2>At wishten, we are always looking for the best for you.</h2>
        </div>
        <img src = "{{ asset('background/a.jpg') }}" alt="About Us Image">
    </div>

    <div class ="about-us">
        <h1>About Us</h1>
    </div>

    <div class ="about-info">
        <div class="about-text">
            <p>Wishten is an end-of-degree dissertation done by students at the Complutense University of Madrid.</p> 
            <p>In Wishten we want to help students to improve their study methods through questionnaires embedded in videos. 
            We also want to make it easier for you to find internships in companies by providing you with a web portal to talk to companies and see their offers.</p>
        </div>
        <div class="about-image">
        <img src = "{{ asset('logo/logo.png') }}" alt="About Us Image">
        </div>
    </div>








@endsection