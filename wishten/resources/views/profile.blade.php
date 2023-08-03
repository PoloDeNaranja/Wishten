@extends('layouts.app')

@section('title', $user->name . '\'s Profile')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ url('/css/profileStyle.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('/css/popupStyle.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('/css/videoListStyle.css') }}" />
@endsection

@section('js')
<script async src="{{ url('/js/popup.js') }}"></script>
@endsection





@section('content')

    @include('layouts.messages')

    <div class="user-info">
        <!-- Cuadro donde va la imagen -->
        @if ($user->profile_pic != 'None')
            <img class="circle" src="{{ url('storage/' . $user->profile_pic) }}" alt="ProfileImage" />
        @else
            <i class="dropbtn fa fa-user-circle-o fa-4x" aria-hidden="true"></i>
        @endif
        <h1 class="name">{{ $user->name }}<h1>
            @if (Auth::user()->can('update', $user))
                <div class="edit-buttons">
                    <button class="openPopup button">Edit profile</button>
                    <button class="openPopup button">Change password</button>
                    <button class="openPopup button red">Delete account</button>
                </div>
            @endif
            @if (Auth::id() != $user->id)
            <form action="{{ route('user.follow', $user) }}" method="post">
                @csrf
                <button class="button" type="submit"><i
                        @if (Auth::user()->isFollowing($user)) title="Unfollow {{ $user->name }}" class="fa-solid fa-user-check"
            @else
                title="Follow {{ $user->name }}" class="fa-solid fa-user-plus" @endif></i></button>
            </form>
            @endif
    </div>

    <ul class="follows-info">
        <!-- Lista donde se meten los numeros de subs seguidos y favoritos -->



        <li>
            <!-- en el numero meter variable de followers following y likes -->
            <a href="{{ route('followers', ['user'  =>  $user->id]) }}">{{ $user->followers()->count() }}</a>
            <p>Followers</p>
        </li>
        <li>
            <a href="{{ route('followed', ['user'  =>  $user->id]) }}">{{ $user->followed_users()->count() }}</a>
            <p>Following</p>
        </li>
        <li>
            <h2>{{ $user->totalFavs() }}</h2>
            <p>Favs</p>
        </li>
        <li>
            <i class="fa-solid fa-heart"></i>
        </li>

    </ul>

    <div class="uploaded-videos">
        <h1>Uploaded Videos</h1>
        <form class="search-bar" action="{{ route('profile') }}" method="get">
            @csrf
            <div>
                <label for="video_title">
                    <input class="search-input" type="text" placeholder="Filter by title" name="video_title" list="video_titles" @isset($video_title) value="{{ $video_title }}"@endif>
                    <input type="hidden" name="user" value="{{ $user->id }}">
                    <datalist id="video_titles">
                        @foreach ($videos as $video)
                            <option value="{{ $video->title }}"></option>
                        @endforeach
                    </datalist>
                    <button class="search-button" type="submit">
                        <i class="fa-sharp fa-solid fa-magnifying-glass"></i>
                    </button>
                </label>
            </div>
        </form>
    </div>


    @if (!$videos || $videos->isEmpty())
        <h1>No videos</h1>
    @else
        <div class="video-list">
            @foreach ($videos as $video)
                <div class="video-card">
                    <img src="{{ url('storage/' . $video->thumb_path) }}" alt="{{ $video->title }}">
                    <a href="{{ route('video.watch', ['video' => $video->id]) }}"></a>
                    <h3>{{ $video->title }}</h3>
                    <p>{{ $video->user->name }}</p>
                </div>
            @endforeach
        </div>
        <a href="{{ route('video.user-videos', ['user' =>  $user]) }}" class="button-more">See more...</a>

    @endif



    @if (Auth::user()->can('update', $user))
        <div class="popup PopupWindow"><!-- popup edición de perfil -->
            <div class="popupContent">
                <span class="closePopup">&times;</span>
                <h3>Modify user "{{ $user->name }}" data</h3>
                <form action="{{ route('profile.update_pic', $user->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <label for="new_pic{{ $user->id }}" class="profile_pic">
                        <input class="form-control" type="file" name="new_pic" id="new_pic{{ $user->id }}" accept=".jpg,.jpeg,.png">
                        @if ($user->profile_pic != 'None')
                            <img src="{{ url('storage/' . $user->profile_pic) }}" alt="mdo" width="60"
                                height="60">
                        @else
                            <i class="fa fa-user-circle-o fa-4x" aria-hidden="true"></i>
                        @endif
                    </label>
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
                            <span class="error-text">{{ $errors->first('name') }}</span>
                        @endif
                    </label>
                    <label>
                        <i class="fa-solid fa-envelope"></i>
                        <input type="email" name="email" value="{{ $user->email }}">
                        @if ($errors->has('email'))
                            <span class="error-text">{{ $errors->first('email') }}</span>
                        @endif
                    </label>
                    <button type="submit" class="button">Save changes</button>
                </form>
            </div>
        </div>


        <div class="popup PopupWindow"><!-- popup cambio de contraseña -->
            <div class="popupContent">
                <span class="closePopup">&times;</span>
                <form action="{{ route('profile.change_password', $user->id) }}" method="POST">
                    @csrf
                    <label>
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" name="old_password" class="InputOldPassword"
                            placeholder="Enter your old password" required>
                        @if ($errors->has('old_password'))
                            <span class="error-text">{{ $errors->first('old_password') }}</span>
                        @endif
                    </label>
                    <label>
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" name="new_password" class="InputNewPassword" placeholder="Enter a new password"
                            required>
                        @if ($errors->has('new_password'))
                            <span class="error-text">{{ $errors->first('new_password') }}</span>
                        @endif
                    </label>
                    <label>
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" name="new_password_confirmation" class="InputPasswordConfirmation"
                            placeholder="Repeat password" required>
                        @if ($errors->has('new_password_confirmation'))
                            <span class="error-text">{{ $errors->first('new_password_confirmation') }}</span>
                        @endif
                    </label>
                    <button type="submit" class="button">Change My Password</button>
                </form>
            </div>
        </div>

        <div class="popup PopupWindow"><!-- popup eliminar cuenta -->
            <div class="popupContent">
                <span class="closePopup">&times;</span>
                <h3>Are you sure you want to delete your account?</h3>
                <p>This action is permanent and cannot be undone, all your content will be deleted and you will lose access to Wishten. Please confirm this action by clicking the button below.</p>

                <form class="delete-account" action="{{ route('user.delete', $user->id) }}" method="post">
                    @csrf
                    <button class="delete-user button red" type="submit">Confirm</button>
                </form>
            </div>
        </div>
    @endif

@endsection
