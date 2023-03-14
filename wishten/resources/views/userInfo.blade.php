@extends('layouts.app')

@section('title', 'Login')


@section('content')

@include('layouts.messages')

@if ($user->profile_pic != 'None')
    <img src="{{ url('storage/'.$user->profile_pic) }}" alt="mdo" class="rounded-circle" width="50" height="50">
@else
    <i class="dropbtn fa fa-user-circle-o fa-xl" aria-hidden="true"></i>
@endif
<p>Email: {{ $user->email }}</p>
<p>Name: {{ $user->name }}</p>


<div class="mb-3">

    <label for="new_pic" class="form-label">Upload a profile picture</label>
    <form action="{{ route('profile.update_pic', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input class="form-control" type="file" name="new_pic" id="new_pic" accept=".jpg,.jpeg,.png">
        <button type="submit" class="btn btn-primary mb-3">Upload</button>
    </form>

    <form action="{{ route('profile.delete_pic', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <button type="submit" class="btn btn-danger mb-3">Delete Picture</button>
    </form>

    <form action="{{ route('profile.update_info', $user->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="InputName">User name</label>
            <input type="text" class="form-control" name="name" id="InputName" value="{{ $user->name }}">
            @if ($errors->has('name'))
                <span class="text-danger">{{ $errors->first('name') }}</span>
            @endif
        </div>
        <div class="form-group">
            <label for="InputEmail">Email address</label>
            <input type="email" class="form-control" name="email" id="InputEmail" aria-describedby="emailHelp" value="{{ $user->email }}">
            @if ($errors->has('email'))
                <span class="text-danger">{{ $errors->first('email') }}</span>
            @endif
        </div>
        <button type="submit" class="btn btn-primary mb-3">Save changes</button>
    </form>


</div>






@endsection



