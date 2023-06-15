@extends('layouts.app')

@section('title', 'Registration')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ url('/css/registrationStyle.css') }}">
@endsection

@section('js')
<script async src="{{ url('/js/showPassword.js') }}"></script>
    <script async src="{{ url('/js/validateInputs.js') }}"></script>
@endsection

@section('header')
@endsection

@section('content')

<form action="{{ route('auth.validate_registration') }}" method="POST">
    <div class="logo-register">
        <a href="/">
            <img src="{{ asset('logo/logo.png') }}" alt = "logo">
        </a>
    </div>
    @csrf
    <h1 class="titulo">Create your account!</h1>
    <label for="name">
       <i class="fa-solid fa-user" id="name-icon"></i>
        <input placeholder="Enter your username" type="text" name="name" id="name" required>
        @if ($errors->has('name'))
            <span class="error-text">{{ $errors->first('name') }}</span>
        @endif
    </label>
    <label for="email">
       <i class="fa-solid fa-envelope" id="email-icon"></i>
        <input placeholder="Enter your e-mail" type="email" name="email" id="email" required>
        @if ($errors->has('email'))
            <span class="error-text">{{ $errors->first('email') }}</span>
        @endif
    </label>
    <div>
        <i class="fa-solid fa-lock" id="password-icon"></i>
        <input type="password" placeholder="Enter your password"  name= "password" id="password" required>
        <button type="button" style="margin-left: 10px" id="show-password">
            <i class="fa fa-eye" aria-hidden="true"></i>
        </button>
        @if ($errors->has('password'))
            <span class="error-text">{{ $errors->first('password') }}</span>
        @endif
    </div>
    <div>
        <i class="fa-solid fa-lock" id="confirm-icon"></i>
        <input placeholder="Confirm password" type="password" name="password_confirmation" id="confirm" required>
        <button type="button" style="margin-left: 10px" id="show">
            <i class="fa fa-eye" aria-hidden="true"></i>
        </button>
        @if ($errors->has('password_confirmation'))
            <span class="error-text">{{ $errors->first('password_confirmation') }}</span>
        @endif
    </div>

    <a href="{{ route('login') }}" class="tiene">Already have an account?</a>

    <button class="button reg">Sign up</button>

</form>


@endsection

@section('footer')
@endsection
