@extends('layouts.app')

@section('title', 'Home')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ url('/css/homeStyle.css') }}">
@endsection

@section('home')
    <div class="home-view">
        <video id="back-video" preload="auto" autoplay loop muted>
            <source src="{{ asset('background/background.mp4') }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <div class="home-content">
            <h1>WELCOME TO WISHTEN!</h1>
            <div class="feature-list">
                <div class="feature">
                    <i class="fa-regular fa-circle-play fa-4x"></i>
                    <p>Here you will find videos to learn whatever you need and you will also be able to upload your own videos!</p>
                </div>
                <div class="feature">
                    <i class="fa-regular fa-circle-question fa-4x"></i>
                    <p>Bring your videos to the next level by adding interactive quizzes to make them even more useful!</p>
                </div>
                <div class="feature">
                    <i class="fa-solid fa-briefcase fa-4x"></i>
                    <p>In Wishten you will also find interesting internship and job offers to make your first contact with the labor market!</p>
                </div>
                <div class="feature">
                    <i class="fa-solid fa-arrow-pointer fa-4x"></i>
                    <p>Navigate through the web and discover all features! The first step is to create an account <a href="/registration">here</a></p>
                </div>


            </div>

            <div class="tutorial-videos">
                <div class="tutorial-video">
                    <h4>How to upload a video</h4>
                    <video controls>
                        <source src="{{ asset('tutorials/UploadVideoTutorial.mp4') }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
                <div class="tutorial-video">
                    <h4>How to upload a video</h4>
                    <video controls>
                        <source src="{{ asset('tutorials/UploadVideoTutorial.mp4') }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>

            </div>
        </div>
    </div>
@endsection

