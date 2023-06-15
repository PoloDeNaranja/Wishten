@extends('layouts.app')

@section('title', Auth::user()->name . '\'s Profile')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ url('/css/popupStyle.css') }}" />

@endsection

@section('js')
    <script async type="text/javascript" src="{{ url('/js/popup.js') }}"></script>
@endsection

@section('content')

    @include('layouts.messages')

    @if ($user->profile_pic != 'None')
        <img src="{{ url('storage/' . $user->profile_pic) }}" alt="mdo" width="60"
            height="60">
    @else
        <i class="dropbtn fa fa-user-circle-o fa-4x" aria-hidden="true"></i>
    @endif
    <p>Email: {{ $user->email }}</p>
    <p>Name: {{ $user->name }}</p>
    <p>Followers: {{ $user->followers()->count() }}</p>

    @if (Auth::id() != $user->id)
        <form action="{{ route('user.follow', $user) }}" method="post">
            @csrf
            <button class="button" type="submit"><i
            @if (Auth::user()->isFollowing($user))
                title="Unfollow {{ $user->name }}" class="fa-solid fa-user-check"
            @else
                title="Follow {{ $user->name }}" class="fa-solid fa-user-plus"
            @endif
            ></i></button>
        </form>
    @endif

    @if (Auth::user()->can('update', $user))
        <button class="openPopup button">Edit profile</button>
        <div id="PopupWindow" class="popup">
            <div class="popupContent">
                <span class="closePopup">&times;</span>
                <h3>Modify user "{{ Auth::user()->name }}" data</h3>
                <form action="{{ route('profile.update_pic', Auth::user()->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <label for="new_pic" class="profile_pic">
                        <input class="form-control" type="file" name="new_pic" id="new_pic" accept=".jpg,.jpeg,.png">
                        @if (Auth::user()->profile_pic != 'None')
                            <img src="{{ url('storage/' . Auth::user()->profile_pic) }}" alt="mdo" width="60"
                                height="60">
                        @else
                            <i class="fa fa-user-circle-o fa-4x" aria-hidden="true"></i>
                        @endif
                    </label>
                    <button type="submit" class="button">Upload</button>
                </form>

                <form action="{{ route('profile.delete_pic', Auth::user()->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <button type="submit" class="button red">Delete Picture</button>
                </form>

                <form action="{{ route('profile.update_info', Auth::user()->id) }}" method="POST">
                    @csrf
                    <label>
                        <i class="fa-solid fa-user"></i>
                        <input type="text" name="name" value="{{ Auth::user()->name }}">
                        @if ($errors->has('name'))
                            <span class="error-text">{{ $errors->first('name') }}</span>
                        @endif
                    </label>
                    <label>
                        <i class="fa-solid fa-envelope"></i>
                        <input type="email" name="email" aria-describedby="emailHelp" value="{{ Auth::user()->email }}">
                        @if ($errors->has('email'))
                            <span class="error-text">{{ $errors->first('email') }}</span>
                        @endif
                    </label>
                    <button type="submit" class="button">Save changes</button>
                </form>
            </div>
        </div>

        </div>
    @endif





@endsection
