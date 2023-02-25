@extends('layouts.app')

@section('title', 'Admin Users')


@section('content')

@include('layouts.messages')


<div class="mb-3">
    <h1>Admin Users</h1>
    <ul>
        @foreach ($users as $user)
            <li>{{$user->name}}</li>
        @endforeach
    </ul>


</div>






@endsection



