@extends('layouts.app')

@section('title', $title)

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ url('/css/userListStyle.css') }}" />
@endsection

@section('content')
    @include('layouts.messages')
    <h1>{{ $title }}</h1>

    <form class="search-bar" action="{{ route($route)}}" method="get">
        @csrf
        <div>
            <label for="user_name">
                <input type="hidden" name="user" value="{{ $user->id }}">
                <input class="search-input" type="text" placeholder="Search user" name="user_name" list="user_names" @isset($user_name) value="{{ $user_name }}"@endif>
                <datalist id="user_names">
                    @foreach ($userlist as $listed_user)
                        <option value="{{ $listed_user->name }}"></option>
                    @endforeach
                </datalist>
                <button class="search-button" type="submit">
                    <i class="fa-sharp fa-solid fa-magnifying-glass"></i>
                </button>
            </label>
        </div>
    </form>


    @if (!$userlist || $userlist->isEmpty())
        <h1>No users</h1>
    @else
        <div class="user-list">
            @foreach ($userlist as $user)
                <div class="user-card">
                    @if ($user->profile_pic != 'None')
                            <img src="{{ url('storage/' . $user->profile_pic) }}">
                        @else
                            <i class="fa fa-user-circle-o fa-4x" aria-hidden="true"></i>
                        @endif
                    <a href="{{ route('profile', ['user'=>$user->id]) }}"></a>
                    <div class="user-info">

                        <h3>{{ $user->name }}</h3>
                        <h4>Since {{ date( "F d, Y", strtotime($user->pivot->followed_at)) }}</h4>

                    </div>


                </div>

            @endforeach
        </div>
    @endif


@endsection
