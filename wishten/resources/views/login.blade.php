@extends('layouts.app')

@section('title', 'Login')

@section('header')
@endsection

@section('footer')
@endsection

@section('content')

@include('layouts.messages')

<div class="row justify-content-center">
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
</div>

@endsection



