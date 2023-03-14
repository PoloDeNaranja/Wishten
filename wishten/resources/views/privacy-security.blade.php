@extends('layouts.app')

@section('title', 'Privacy and Security')


@section('content')

@include('layouts.messages')


<div class="mb-3">
    <div class="card-header">Change password</div>
    <form action="{{ route('profile.change_password', Auth::id()) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="InputOldPassword">Old Password</label>
            <input type="password" class="form-control" name="old_password" id="InputOldPassword" placeholder="Enter your old password">
            @if ($errors->has('old_password'))
                <span class="text-danger">{{ $errors->first('old_password') }}</span>
            @endif
        </div>
        <div class="form-group">
            <label for="InputNewPassword">New Password</label>
            <input type="password" class="form-control" name="new_password" id="InputNewPassword" placeholder="Enter a new password">
            @if ($errors->has('new_password'))
                <span class="text-danger">{{ $errors->first('new_password') }}</span>
            @endif
        </div>
        <div class="form-group">
            <label for="InputPasswordConfirmation">Confirm password</label>
            <input type="password" class="form-control" name="new_password_confirmation" id="InputPasswordConfirmation" placeholder="Repeat password" required>
            @if ($errors->has('new_password_confirmation'))
                <span class="text-danger">{{ $errors->first('new_password_confirmation') }}</span>
            @endif
        </div>
        <button type="submit" class="btn btn-primary">Change My Password</button>
    </form>



</div>






@endsection



