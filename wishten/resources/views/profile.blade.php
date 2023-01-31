@extends('layouts.app')

@section('title', 'Login')


@section('content')

@include('layouts.messages')

@if (Auth::user()->profile_pic != 'None')
                    <img src="{{ url('storage/'.Auth::user()->profile_pic) }}" alt="mdo" class="rounded-circle" width="50" height="50">
                @else
                    <img src="{{ url('storage/profile_pics/default.png') }}" alt="mdo" class="rounded-circle" width="50" height="50">
                @endif
<p>Email: {{ Auth::user()->email }}</p>
<p>Name: {{ Auth::user()->name }}</p>


<div class="mb-3">

    <label for="new_pic" class="form-label">Upload a profile picture</label>
    <form action="{{ route('profile.update_pic') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input class="form-control" type="file" name="new_pic" id="new_pic" accept=".jpg,.jpeg,.png">
        <button type="submit" class="btn btn-primary mb-3">Upload</button>
    </form>

    <form action="">
        <label for="email" class="form-label">Email address</label>
        <input type="email" class="form-control" id="email" value="{{ Auth::user()->email }}">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" value="{{ Auth::user()->name }}">
    </form>

<form action="">
    <div class="form-group">
        <label for="InputPassword">New Password</label>
        <input type="password" class="form-control" name="password" id="InputPassword" placeholder="Enter password">
        @if ($errors->has('password'))
            <span class="text-danger">{{ $errors->first('password') }}</span>
        @endif
    </div>
    <div class="form-group">
        <label for="InputPasswordConfirmation">Confirm password</label>
        <input type="password" class="form-control" name="password_confirmation" id="InputPasswordConfirmation" placeholder="Repeat password" required>
        @if ($errors->has('password_confirmation'))
            <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
        @endif
    </div>
</form>

</div>






@endsection



