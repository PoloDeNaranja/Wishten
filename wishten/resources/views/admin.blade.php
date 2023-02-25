@extends('layouts.app')

@section('title', 'Admin')


@section('content')

@include('layouts.messages')


<div class="mb-3">
    <h1>Administration</h1>
    <a class="dropdown-item" href="{{ route('adminUsers') }}">Users Administration</a>




</div>






@endsection



