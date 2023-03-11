@extends('layouts.app')

@section('title', 'Admin Users')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ url('/css/adminStyle.css') }}" />
@endsection

@section('content')

    @include('layouts.messages')

    <h1>Admin Users</h1>
    @foreach ($users as $user)
        <div class="user-data">
            <form action="" method="post">
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
        </div>
    @endforeach



@endsection



