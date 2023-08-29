@extends('layouts.app')

@section('title', 'Admin Messages')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ url('/css/adminStyle.css') }}">
@endsection

@section('js')
    <script async src="{{ url('/js/filterTable.js') }}"></script>
    <script async src="{{ url('/js/validateInputs.js') }}"></script>

@endsection

@section('content')

    @include('layouts.messages')

    <h1>Admin Messages</h1>
    
    <input type="text" id="searchInput" onkeyup="filterTable()" placeholder="Search by conversation">
    <div id="adminTable">
        <table id="filteredTable" class="userInfo">
            <tr class="header">
                <th>ID</th>
                <th>Id_Conversation</th>
                <th>Id_Sender</th>
                <th>Content</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
            @foreach ($messages as $message)
                <tr>
                    <td>{{ $message->id }}</td>
                    <td>{{ $message->id_conversation }}</td>
                    <td>{{ $message->id_sender }}</td>
                    <td>{{ $message->content }}</td>
                    <td>{{ $message->date }}</td>
                    <td>
                        <div class="action-buttons">

                            <form action="{{ route('message.delete', ['message' => $message->id]) }}" method="post">
                                @csrf
                                <button class="button red" type="submit">Delete</button>
                            </form>
                        </div>
                    </td>

                    
                </tr>

            @endforeach
        </table>
    </div>

    



@endsection
