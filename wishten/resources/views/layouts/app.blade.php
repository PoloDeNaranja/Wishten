<!DOCTYPE html>
<html lang="en">

<head>
    <title>Wishten - @yield('title')</title>
    {{-- Favicon --}}
    <link rel="shortcut icon" type="image/png" href="{{ asset('logo/logo.png') }}">

    <!--Esto es para moviles -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- CSS --}}
    <link rel="stylesheet" type="text/css" href="{{ url('/css/appStyle.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('/css/headerStyle.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('/css/footerStyle.css') }}">
    @yield('css')

    {{-- Scripts --}}
    <script async src="{{ url('/js/dropdown.js') }}"></script>
    <script async src="https://kit.fontawesome.com/0d34bde1b9.js" crossorigin="anonymous"></script>
    @yield('js')


</head>

<body>
    @section('header')
    <header>
        <a href="/" class="logo">
        <img src="{{ asset('logo/logo.png') }}" alt = "logo">
        </a>
        <nav>
            <a href="/" class="nav-link" title="Home"><i class="fa-solid fa-house"></i></a>
            {{-- <a href="videos" class="nav-link">Videos</a> --}}
            <a href="'{{ route('home-2') }}" class="nav-link" title="Offers"><i class="fa-solid fa-briefcase"></i></a>
            <a href="#" class="nav-link" title="Tutorials"><i class="fa-solid fa-circle-question"></i></a>
            {{-- <a href="#" class="nav-link">Noticias</a> --}}
            {{-- <img class="notificacion"src="notificacion.png" alt = "notificacion"></a>--}}
            @guest
              <a class="nav-link" href="{{ route('login') }}">Log in</a>
              <a class="nav-link" href="{{ route('registration') }}">Sign up</a>
            @else
                <div class="dropdown">
                    <a href="#" onclick="toggleDropdown()" class="dropbtn" aria-expanded="false">
                        @if (Auth::user()->profile_pic != 'None')
                            <img src="{{ url('storage/'.Auth::user()->profile_pic) }}" alt="mdo" class="dropbtn" width="32" height="32">
                        @else
                            <i class="dropbtn fa fa-user-circle-o fa-xl" aria-hidden="true"></i>
                        @endif
                    </a>
                    <div id="myDropdown" class="dropdown-content">
                        <a href="{{ route('new-video') }}">New video...</a>
                        <a href="{{ route('my-videos') }}">My Videos</a>
                        <a href="{{ route('fav-videos') }}">Favourite Videos</a>
                        <a href="{{ route('profile', ['user'=>Auth::user()]) }}">Profile</a>
                        @if (Auth::user()->role == 'admin')
                            <a class="dropdown-item" href="{{ '/admin' }}">Administration</a>
                        @endif
                        <hr>
                        <a href="{{ '/logout' }}">Log out</a>
                    </div>
                </div>
            @endguest
        </nav>
    </header>

    @show

    @yield('home')

    <div class="container">
        @yield('content')
    </div>

    @section('footer')

        <footer>

            <div class="info">
                <h2>Wishten</h2>
                <a href="#">About us</a>
                <a href="#">FAQ</a>
                <a href="#">Services</a>
            </div>
            <div class="redes">
            <a href="https://github.com/PoloDeNaranja/Wishten" class="nav-link" title="Github">
                <i class="fa-brands fa-github"></i>
            </a>
            <a href="#" class="nav-link">
                <i class="fa-brands fa-facebook"></i>
            </a>
            <a href="#" class="nav-link">
                <i class="fa-brands fa-instagram"></i>
            </a>
            <a href="#" class="nav-link">
                <i class="fa-brands fa-twitter"></i>
            </a>
            </div>
            <div class="logo foot">
            <a href="/">
                <img src="{{ asset('logo/logo.png') }}" alt = "logo">
                </a>
            </div>
            <div class="cop">
                <p class = "copyright"> &copy; 2023 by Wishten</p>
            </div>

        </footer>
    @show

</body>

</html>
