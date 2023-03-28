@extends('layouts.app')

@section('title', 'Admin Users')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ url('/css/adminStyle.css') }}" />
@endsection

@section('js')
    <script async type="text/javascript" src="{{ url('/js/popup.js') }}"></script>
@endsection

@section('content')

    @include('layouts.messages')

    <h1>Admin Users</h1>
    @foreach ($users as $user)
        {{-- <div class="user-data">
            <form action="{{ route('profile.update_info', Auth::id()) }}" method="post">
                @csrf
                <input type="text" name="name" value="{{ $user->name }}">
                <input type="text" name="email" value="{{ $user->email }}">
                <select name="roles" id="roles" >
                    <option value="admin">admin</option>
                    <option value="standard">standard</option>
                    <option value="company">company</option>
                </select>
                <button type="submit">Save changes</button>
            </form>
            <button>Ban</button>
        </div> --}}
        <a href="{{ route('userInfo', $user->id) }}">{{ $user->name }}</a>
        <button id="openPopup" onclick="openPopup('PopupWindow {{ $user->name }}')">Modify</button>
        <div class="popup" id="PopupWindow {{ $user->name }}" class="popup">
            <div class="popupContent">
                <span class="closePopup" onclick="closePopup('PopupWindow {{ $user->name }}')">&times;</span>
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

                <form action="{{ route('adminUsers.ban', $user->id) }}" method="post">
                    @csrf
                    @if ($user->ban)
                        <button type="submit">Unban</button>
                    @else
                        <button type="submit">Ban</button>
                    @endif
                </form>
            </div>
        </div>
    @endforeach



@endsection



