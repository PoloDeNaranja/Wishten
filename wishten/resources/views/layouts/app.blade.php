<!DOCTYPE html>
<html lang="en">

<head>
    <title>Wishten - @yield('title')</title>
    {{-- Favicon --}}
    <link rel="shortcut icon" type="image/png" href="{{ asset('logo/logo.png') }}">

    <!--Esto es para moviles -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- CSS --}}
    <link rel="stylesheet" type="text/css" href="{{ url('/css/appStyle.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ url('/css/headerStyle.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ url('/css/footerStyle.css') }}" />


    {{-- Scripts --}}
    <script async type="text/javascript" src="{{ url('/js/dropdown.js') }}"></script>
    <script async src="https://kit.fontawesome.com/0d34bde1b9.js" crossorigin="anonymous"></script>

    {{-- Para añadir más ficheros CSS y JavaScript --}}
    @yield('css')
    @yield('js')
</head>

<body>
    @section('header')
    <header>
        <a href="/" class="logo">
        <img src="{{ asset('logo/logo.png') }}" alt = "logo">
        </a>
        <nav>
            <a href="/" class="nav-link">Home</a>
            <a href="videos" class="nav-link">Videos</a>
            <a href="#" class="nav-link">Offers</a>
            <!-- <ul>
                    <li><a href="">1º Cuatrimestre</li>
                    <li><a href="">2º Cuatrimestre</li>
                    <li><a href="">Extracurriculares</li>
            </ul> -->
            {{-- <a href="#" class="nav-link">Noticias</a> --}}
            {{-- <a href=""> --}}
            {{-- <img class="notificacion"src="notificacion.png" alt = "notificacion">
            </a>
            <a href="">
            <img class="perfil"src="perfil.png" alt = "logo">
            </a> --}}
            @guest
              <a class="nav-link" href="{{ route('login') }}">Login</a>
              <a class="nav-link" href="{{ route('registration') }}">Register</a>
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
                        <a href="#">Settings</a>
                        <a href="{{ route('my-videos') }}">My Videos</a>
                        <a href="{{ route('profile') }}">Profile</a>
                        <a href="{{ route('privacy-security') }}">Privacy and Security</a>
                        @if (Auth::user()->role == 'admin')
                            <a class="dropdown-item" href="{{ '/admin' }}">Administration</a>
                        @endif
                        <hr>
                        <a href="{{ '/logout' }}">Logout</a>
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
            <a href="https://twitter.com" class="nav-link">
                <i class="fa-brands fa-facebook"></i>
            </a>
            <a href="https://www.instagram.com" class="nav-link">
                <i class="fa-brands fa-instagram"></i>
            </a>
            <a href="https://facebook.com" class="nav-link">
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
