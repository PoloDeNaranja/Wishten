@extends('layouts.app')

@section('title', 'Admin')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ url('/css/adminStyle.css') }}" />
@endsection

@section('content')

@include('layouts.messages')



    <h1>Administration</h1>
    <a class="admin-element" href="{{ route('adminUsers') }}">Users Administration</a>







@endsection



