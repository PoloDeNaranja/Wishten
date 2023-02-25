<!DOCTYPE html>
<html lang="en">

<head>
    <title>Wishten - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    {{-- Para añadir ficheros CSS y JavaScript propios --}}
    @yield('css')
    @yield('js')
</head>

<body>
    @section('header')

    <header class="d-flex justify-content-center py-3">

    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">

          <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
            <li><a href="/" class="nav-link px-2 link-primary">Home</a></li>
            <li><a href="#" class="nav-link px-2 link-dark">Inventory</a></li>
            <li><a href="#" class="nav-link px-2 link-dark">Customers</a></li>
            <li><a href="#" class="nav-link px-2 link-dark">Products</a></li>
          </ul>

          <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3">
            <input type="search" class="form-control" placeholder="Search..." aria-label="Search">
          </form>
          @guest
              <a class="nav-link" href="{{ route('login') }}">Login</a>
              <a class="nav-link" href="{{ route('registration') }}">Register</a>
          @else
          <div class="dropdown text-end">
            <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                @if (Auth::user()->profile_pic != 'None')
                    <img src="{{ url('storage/'.Auth::user()->profile_pic) }}" alt="mdo" class="rounded-circle" width="32" height="32">
                @else
                    <img src="{{ url('storage/profile_pics/default.png') }}" alt="mdo" class="rounded-circle" width="32" height="32">
                @endif
            </a>
            <ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1">
              <li><a class="dropdown-item" href="#">New project...</a></li>
              <li><a class="dropdown-item" href="#">Settings</a></li>
              <li><a class="dropdown-item" href="{{ route('profile') }}">Profile</a></li>
              <li><a class="dropdown-item" href="{{ route('privacy-security') }}">Privacy and Security</a></li>
              @if (Auth::user()->role == 'admin')
                    <li><a class="dropdown-item" href="{{ 'admin' }}">Administration</a></li>
              @endif
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="{{ 'logout' }}">Logout</a></li>
            </ul>
          </div>
          @endguest
        </div>
      </div>

      </header>

    @show

    <div class="container">
        @yield('content')
    </div>

    {{-- @section('footer')

        <div class="container">
            <span class="text-muted">Place sticky footer content here.</span>
        </div>
    @show --}}

</body>

</html>
