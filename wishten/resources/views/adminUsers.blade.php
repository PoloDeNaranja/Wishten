@extends('layouts.app')

@section('title', 'Admin Users')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ url('/css/adminStyle.css') }}" />
@endsection

@section('content')

@include('layouts.messages')


<div class="mb-3">
    <h1>Admin Users</h1>
    <ul>
        @foreach ($users as $user)
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
        @endforeach
    </ul>


</div>






@endsection



