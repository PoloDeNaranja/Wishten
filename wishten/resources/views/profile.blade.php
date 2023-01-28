@extends('layouts.app')

@section('title', 'Login')


@section('content')

@include('layouts.messages')

<div class="mb-3">
    <label for="formFile" class="form-label">Upload a profile picture</label>
    <form action="{{ route('profile.update_pic') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input class="form-control" type="file" name="new_pic" id="new_pic" accept=".jpg,.jpeg,.png">
        <button type="submit" class="btn btn-primary mb-3">Upload</button>
    </form>
</div>


@endsection



