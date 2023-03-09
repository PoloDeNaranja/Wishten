@extends('layouts.app')

@section('title', 'Login')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ url('/css/loginStyle.css') }}" />
@endsection

@section('header')
@endsection



@section('content')

@include('layouts.messages')
<form action="{{ route('auth.validate_login') }}" method="POST">
    @csrf
    <h1 class="title">Login</h1>
    <label>
        <i class="fa-solid fa-envelope"></i>
        <input placeholder="e-mail" type="text" name="email" id="InputEmail">
        @if ($errors->has('email'))
            <span class="error-text">{{ $errors->first('email') }}</span>
        @endif
    </label>
    <label>
        <i class="fa-solid fa-lock"></i>
        <input placeholder="password" type="password" name="password" id="InputPassword">
        @if ($errors->has('password'))
            <span class="error-text">{{ $errors->first('password') }}</span>
        @endif
    </label>

    <a href="#" class="forgot">Password forgotten?</a>

    <button type="submit" class="button-log">Sign in</button>
    <a class="button-reg" href="{{ route('registration') }}">Sign up</a>


</form>
{{-- <div class="row justify-content-center">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">Registration</div>
            <div class="card-body">
                <form action="{{ route('auth.validate_login') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="InputEmail">Email address</label>
                        <input type="email" class="form-control" name="email" id="InputEmail" aria-describedby="emailHelp" placeholder="Enter email">
                        @if ($errors->has('email'))
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="InputPassword">Password</label>
                        <input type="password" class="form-control" name="password" id="InputPassword" placeholder="Enter password">
                        @if ($errors->has('password'))
                            <span class="text-danger">{{ $errors->first('password') }}</span>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
                </form>
            </div>
        </div>
    </div>
</div> --}}

@endsection


@section('footer')
@endsection


