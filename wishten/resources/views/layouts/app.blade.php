<!DOCTYPE html>
<html lang="en">

<head>
    <title>Wishten - @yield('title')</title>
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script> --}}

    <!--Esto es para moviles -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- CSS --}}
    <link rel="stylesheet" type="text/css" href="{{ url('/css/appStyle.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ url('/css/headerStyle.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ url('/css/footerStyle.css') }}" />


    {{-- Scripts --}}
    <script async type="text/javascript" src="{{ url('/js/headerScript.js') }}"></script>
    <script async src="https://kit.fontawesome.com/0d34bde1b9.js" crossorigin="anonymous"></script>

    {{-- Para añadir más ficheros CSS y JavaScript --}}
    @yield('css')
    @yield('js')
</head>

<body>
    @section('header')
    <header>
        <a href="#" class="logo">
        <img src="logo.png" alt = "logo">
        </a>
        <nav>
            <a href="/" class="nav-link">Home</a>
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
                        <a href="#">New project...</a>
                        <a href="#">Settings</a>
                        <a href="{{ route('profile') }}">Profile</a>
                        <a href="{{ route('privacy-security') }}">Privacy and Security</a>
                        @if (Auth::user()->role == 'admin')
                            <a class="dropdown-item" href="{{ 'admin' }}">Administration</a>
                        @endif
                        <hr>
                        <a href="{{ '/logout' }}">Logout</a>
                    </div>
                </div>
            @endguest
        </nav>
    </header>

    @show

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
            <a href="https://twitter.com" class="nav-link"></a>
                <i class="fa-brands fa-facebook"></i>
            </a>
            <a href="https://www.instagram.com" class="nav-link"></a>
                <i class="fa-brands fa-instagram"></i>
            </a>
            <a href="https://facebook.com" class="nav-link"></a>
                <i class="fa-brands fa-twitter"></i>
            </a>
            </div>
            <div class="logo">
            <a href="">
                <img class="logo"src="logo.png" alt = "logo">
                </a>
            </div>
            <div class="cop">
                <p class = "copyright"> &copy; 2023 by Wishten</p>
            </div>

        </footer>
    @show

</body>

</html>
