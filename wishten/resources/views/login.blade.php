@extends('layouts.app')

@section('title', 'Login')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ url('/css/loginStyle.css') }}">
@endsection

@section('js')
<script async src="{{ url('/js/showPassword.js') }}"></script>
@endsection

@section('header')
@endsection



@section('content')

@include('layouts.messages')



<form action="{{ route('auth.validate_login') }}" method="POST">
    <div class="logo-login">
        <a href="/">
            <img src="{{ asset('logo/logo.png') }}" alt = "logo">
        </a>
    </div>
    @csrf
    <h1 class="title">Wishten</h1>
    <label>
        <i class="fa-solid fa-envelope"></i>
        <input placeholder="e-mail" type="text" name="email">
        @if ($errors->has('email'))
            <span class="error-text">{{ $errors->first('email') }}</span>
        @endif
    </label>
    <div>
        <i class="fa-solid fa-lock"></i>
        <input placeholder="password" type="password" name="password" id="password">
        <button type="button" style="margin-left: 10px" id="show-password">
            <i class="fa fa-eye" aria-hidden="true"></i>
        </button>
        @if ($errors->has('password'))
            <span class="error-text">{{ $errors->first('password') }}</span>
        @endif
    </div>

    <button type="submit" class="button-log">Log in</button>
    <a class="button-reg" href="{{ route('registration') }}">Sign up</a>


</form>


@endsection


@section('footer')
@endsection


