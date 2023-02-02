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

    <form action="{{ route('profile.delete_pic') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <button type="submit" class="btn btn-danger mb-3">Delete Picture</button>
    </form>

    <form action="{{ route('profile.update_info') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="InputUsername">User name</label>
            <input type="text" class="form-control" name="username" id="InputUsername" value="{{ Auth::user()->name }}">
            @if ($errors->has('username'))
                <span class="text-danger">{{ $errors->first('username') }}</span>
            @endif
        </div>
        <div class="form-group">
            <label for="InputEmail">Email address</label>
            <input type="email" class="form-control" name="email" id="InputEmail" aria-describedby="emailHelp" value="{{ Auth::user()->email }}">
            @if ($errors->has('email'))
                <span class="text-danger">{{ $errors->first('email') }}</span>
            @endif
        </div>
        <button type="submit" class="btn btn-primary mb-3">Save changes</button>
    </form>


</div>






@endsection



