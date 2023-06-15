@extends('layouts.app')

@section('title', 'Admin Users')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ url('/css/adminStyle.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('/css/popupStyle.css') }}">

@endsection

@section('js')
<script async src="{{ url('/js/popup.js') }}"></script>
    <script async src="{{ url('/js/filterTable.js') }}"></script>
@endsection

@section('content')

    @include('layouts.messages')

    <h1>Admin Videos</h1>
    <input type="text" id="searchInput" onkeyup="filterTable()" placeholder="Search video by title">
    <div id="userList">
        <table id="filteredTable" class="userInfo">
            <tr class="header">
                <th>ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Subject</th>
                <th>Owner</th>
                <th>Video path</th>
                <th>Thumbnail path</th>
                <th>Created at</th>
                <th>Updated at</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            @foreach ($videos as $video)
                <tr>
                    <td>{{ $video->id }}</td>
                    <td>{{ $video->title }}</td>
                    <td>{{ $video->description }}</td>
                    <td>{{ $video->subject->name }}</td>
                    <td>{{ $video->user->name }}</td>
                    <td><a class="filepath" href="{{ url('storage/'.$video->video_path) }}">{{ $video->video_path }}</a></td>
                    <td><a class="filepath" href="{{ url('storage/'.$video->thumb_path) }}">{{ $video->thumb_path }}</a></td>
                    <td>{{ $video->created_at }}</td>
                    <td>{{ $video->updated_at }}</td>
                    <td>{{ Str::upper($video->status) }}</td>

                    <td>
                        <form class="action-buttons" action="{{ route('video.delete', ['video' => $video->id, 'admin' => true]) }}" method="post">
                            @csrf
                            <a href="{{ route('video.watch', ['video'=>$video->id]) }}" class="button">Watch</a>
                            <button class="openPopup button" type="button">Modify</button>
                            <button class="delete-video button red" type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>

@endsection
