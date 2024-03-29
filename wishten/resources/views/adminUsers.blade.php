@extends('layouts.app')

@section('title', 'Admin Users')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ url('/css/adminStyle.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('/css/popupStyle.css') }}">
@endsection

@section('js')
<script async src="{{ url('/js/popup.js') }}"></script>
    <script async src="{{ url('/js/showPassword.js') }}"></script>
    <script async src="{{ url('/js/filterTable.js') }}"></script>
@endsection

@section('content')

    @include('layouts.messages')

    <h1>Admin Users</h1>
    <input type="text" id="searchInput" onkeyup="filterTable()" placeholder="Search user name">
    <div id="adminTable">
        <table id="filteredTable" class="userInfo">
            <tr class="header">
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Created at</th>
                <th>Updated at</th>
                <th>Action</th>
            </tr>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->created_at }}</td>
                    <td>{{ $user->updated_at }}</td>

                    <td>
                        <button class="openPopup button" type="button"
                            @if (Auth::user()->id == $user->id) disabled @endif>Modify</button>
                        <button class="openPopup button" type="button"
                            @if (Auth::user()->id == $user->id) disabled @endif>Password</button>
                        <button class="openPopup button red" type="submit"
                            @if (Auth::user()->id == $user->id) disabled @endif>Delete</button>

                    </td>
                </tr>
            @endforeach
        </table>
    </div>
    @foreach ($users as $user)
        <div class="popup PopupWindow">
            <div class="popupContent">
                <span class="closePopup">&times;</span>
                <h3>Modify user "{{ $user->name }}" data</h3>
                <form action="{{ route('profile.update_pic', $user->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <label for="new_pic{{$user->id}}" class="profile_pic">
                        <input class="form-control" type="file" name="new_pic" id="new_pic{{$user->id}}" accept=".jpg,.jpeg,.png">
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
                <form action="{{ route('adminUsers.changeRole', $user->id) }}" method="post">
                    @csrf
                    <select name="roles" class="roles">
                        <option value="admin" @if ($user->isAdmin()) selected @endif>admin</option>
                        <option value="standard" @if ($user->role == 'standard') selected @endif>standard</option>
                        <option value="company" @if ($user->role == 'company') selected @endif>company</option>
                    </select>
                    <button type="submit" class="button">Change role</button>
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
        <div class="popup PopupWindow">
            <div class="popupContent">
                <span class="closePopup">&times;</span>
                <form action="{{ route('adminUsers.setPassword', $user->id) }}" method="POST">
                    @csrf
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
                    <button type="submit" class="button">Change Password</button>
                </form>
            </div>
        </div>

        <div class="popup PopupWindow">
            <div class="popupContent">
                <span class="closePopup">&times;</span>
                <h3>Are you sure you want to delete this account?</h3>
                <p>This action is permanent and cannot be undone. Please confirm this action by clicking the button below.</p>

                <form class="delete-account" action="{{ route('user.delete', $user->id) }}" method="post">
                    @csrf
                    <button class="delete-user button red" type="submit">Confirm</button>
                </form>
            </div>
        </div>
    @endforeach
    <button id="addUser" class="openPopup button">Add user</button>
    <div class="popup PopupWindow">
        <div class="popupContent">
            <span class="closePopup">&times;</span>
            <form action="{{ route('adminUsers.addUser') }}" method="POST">
                @csrf
                <h1 class="titulo">Create your account!</h1>
                <label>
                    <i class="fa-solid fa-user"></i>
                    <input placeholder="Enter your username" type="text" name="name" id="name" required>
                    @if ($errors->has('name'))
                        <span class="error-text">{{ $errors->first('name') }}</span>
                    @endif
                </label>
                <label>
                    <i class="fa-solid fa-envelope"></i>
                    <input placeholder="Enter your e-mail" type="email" name="email" id="email" required>
                    @if ($errors->has('email'))
                        <span class="error-text">{{ $errors->first('email') }}</span>
                    @endif
                </label>
                <div>
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" placeholder="Enter your password" name="password" id="password" required>
                    <button type="button" style="margin-left: 10px" id="show-password">
                        <i class="fa fa-eye" aria-hidden="true"></i>
                    </button>
                    @if ($errors->has('password'))
                        <span class="error-text">{{ $errors->first('password') }}</span>
                    @endif
                </div>
                <div>
                    <i class="fa-solid fa-lock"></i>
                    <input placeholder="Confirm password" type="password" name="password_confirmation" id="confirm"
                        required>
                    <button type="button" style="margin-left: 10px" id="show">
                        <i class="fa fa-eye" aria-hidden="true"></i>
                    </button>
                    @if ($errors->has('password_confirmation'))
                        <span class="error-text">{{ $errors->first('password_confirmation') }}</span>
                    @endif
                </div>
                <button class="button reg">Add user</button>

            </form>
        </div>
    </div>

@endsection
