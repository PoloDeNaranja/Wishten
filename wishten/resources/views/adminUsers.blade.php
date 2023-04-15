@extends('layouts.app')

@section('title', 'Admin Users')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ url('/css/adminStyle.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ url('/css/popupStyle.css') }}" />

@endsection

@section('js')
    <script async type="text/javascript" src="{{ url('/js/popup.js') }}"></script>
@endsection

@section('content')

    @include('layouts.messages')

    <h1>Admin Users</h1>
    <div id="userList">
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

            <p>{{ $user->name }}</p>
            <button class="openPopup button">Modify</button>

            <div id="PopupWindow" class="popup">
                <div class="popupContent">
                    <span class="closePopup">&times;</span>
                    <label for="new_pic" class="form-label">Upload a profile picture</label>
                    <form action="{{ route('profile.update_pic', $user->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input class="form-control" type="file" name="new_pic" id="new_pic" accept=".jpg,.jpeg,.png">
                        <button type="submit" class="button">Upload</button>
                    </form>

                    <form action="{{ route('profile.delete_pic', $user->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <button type="submit" class="button red">Delete Picture</button>
                    </form>

                    <form action="{{ route('profile.update_info', $user->id) }}" method="POST">
                        @csrf
                        <label>
                            <i class="fa-solid fa-user"></i>
                            <input type="text" name="name" value="{{ $user->name }}">
                            @if ($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif
                        </label>
                        <label>
                            <i class="fa-solid fa-envelope"></i>
                            <input type="email" name="email" aria-describedby="emailHelp" value="{{ $user->email }}">
                            @if ($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                            @endif
                        </label>
                        <button type="submit" class="button">Save changes</button>
                    </form>

                    <form action="{{ route('adminUsers.ban', $user->id) }}" method="post">
                        @csrf
                        @if ($user->ban)
                            <button type="submit" class="button">Unban</button>
                        @else
                            <button type="submit" class="button red">Ban</button>
                        @endif
                    </form>
                </div>
            </div>
        @endforeach
    </div>


@endsection



