@extends('layouts.app')

@section('title', 'Admin Users')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ url('/css/adminStyle.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('/css/popupStyle.css') }}">

@endsection

@section('js')
    <script async src="{{ url('/js/popup.js') }}"></script>
    <script async src="{{ url('/a.js') }}"></script>
    <script async src="{{ url('/js/filterTable.js') }}"></script>
    <script async src="{{ url('/js/popup.js') }}"></script>
    <script async src="{{ url('/js/validateInputs.js') }}"></script>

@endsection

@section('content')

    @include('layouts.messages')

    <h1>Admin Offers</h1>
    <input type="text" id="searchInput" onkeyup="filterTable()" placeholder="Search offer by title">
    <div id="adminTable">
        <table id="filteredTable" class="userInfo">
            <tr class="header">
                <th>ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Owner</th>
                <th>Vacants</th>
                <th>Salary €</th>
                <th>File</th>
                <th>Created at</th>
                <th>Updated at</th>
                <th>Action</th>
            </tr>
            @foreach ($offers as $offer)
                <tr>
                    <td>{{ $offer->id }}</td>
                    <td>{{ $offer->title }}</td>
                    <td>{{ $offer->description }}</td>
                    <td>{{ $offer->user->name }}</td>
                    <td>{{ $offer->vacants }}</td>
                    <td>{{ $offer->salary }}</td>
                    <td><a class="filepath" href="{{ url('storage/'.$offer->document_path) }}">
                        <i class="fa-solid fa-file  fa-xl fa-xl"></i>
                    </a></td>
                    <td>{{ $offer->created_at }}</td>
                    <td>{{ $offer->updated_at }}</td>
                    <td>
                        <form class="action-buttons" action="{{ route('offer.delete', ['offer' => $offer->id, 'admin' => true]) }}" method="post">
                            @csrf
                            <button class="delete-offer button red" type="submit">Delete</button>
                        </form>
                    </td>     
                </tr>
            @endforeach
        </table>
    </div>
   
    <button id="addOffer" class="openPopup button">Add Offer</button>
    <div class="popup PopupWindow">
        <div class="popupContent">
            <span class="closePopup">&times;</span>
            <form action="{{ route('offer.upload', Auth::id()) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <label for="offer" title="Select your offer file">
                    <i id="offer-icon" class="fa-solid fa-file fa-bounce fa-10x"></i>
                    <input type="file" name="offer" id="offer" accept=".pdf,.txt,.doc,.jpg,.jpeg,.png,.docx" required>
                </label>

                <label for="title">
                    <input type="text" placeholder="Title of your offer" name="title" id="title" required>
                </label>
                <label for="description">
                    <textarea placeholder="Description of your offer" name="description" rows="4" cols="50" id="description" required></textarea>
                </label>
                <label for="vacants">
                    Vacants:
                    <input type="number" name="vacants" id="vacants" min="0" required>
                </label>
                <label for="salary">
                    Salary <span>&euro;</span>:  
                    <input type="number" name="salary" id="salary" min="0" required>
                </label>
                <button type="submit" class="button">Upload Offer</button>

            </form>
        </div>
    </div>

@endsection
