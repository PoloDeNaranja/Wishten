@extends('layouts.app')

@section('title', 'Admin Users')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ url('/css/adminStyle.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('/css/popupStyle.css') }}">

@endsection

@section('js')
<script async src="{{ url('/js/popup.js') }}"></script>
    <script async src="{{ url('/js/filterTable.js') }}"></script>
    <script async src="{{ url('/js/popup.js') }}"></script>
@endsection

@section('content')

    @include('layouts.messages')

    <h1>Admin Videos</h1>
    <input type="text" id="searchInput" onkeyup="filterTable()" placeholder="Search video by title">
    <div id="adminTable">
        <table id="filteredTable" class="userInfo">
            <tr class="header">
                <th>ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Subject</th>
                <th>Owner</th>
                <th>Video</th>
                <th>Thumbnail</th>
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
                    <td><a class="filepath" href="{{ url('storage/'.$video->video_path) }}">
                        <i class="fa-solid fa-file-video fa-xl"></i>
                    </a></td>
                    <td><a class="filepath" href="{{ url('storage/'.$video->thumb_path) }}">
                        <i class="fa-solid fa-images fa-xl"></i>
                    </a></td>
                    <td>{{ $video->created_at }}</td>
                    <td>{{ $video->updated_at }}</td>
                    <td class="status-{{ $video->status }}">{{ strtoupper($video->status) }}</td>

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
    @foreach ($videos as $video)
        <div class="popup PopupWindow">
            <div class="popupContent">
                <span class="closePopup">&times;</span>
                <h3>Modify video "{{ $video->title }}" data</h3>
                <form action="{{ route('video.set_status', $video->id) }}" method="post">
                    @csrf
                    <a href="{{ route('video.edit', ['video' => $video->id]) }}" class="button" title="Edit video information">Edit</a>
                    <h4>Set status</h4>
                    <select name="status" class="status">
                        <option value="valid" @if ($video->status == 'valid') selected @endif>valid</option>
                        <option value="pending" @if ($video->status == 'pending') selected @endif>pending</option>
                        <option value="blocked" @if ($video->status == 'blocked') selected @endif>blocked</option>
                    </select>
                    <button type="submit" class="button" title="Apply status">
                        <i class="fa-regular fa-circle-check fa-lg"></i>
                    </button>
                </form>
            </div>
        </div>
    @endforeach


@endsection
