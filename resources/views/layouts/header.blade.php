<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Cinema Blu-ray</title>
    <link href="css/bootstrap.css" rel="stylesheet">
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <style>
    .red-after:hover {
        color: rgba(var(--bs-danger-rgb), var(--bs-bg-opacity)) !important;
    }
    </style>
</head>
<body class="bg-dark" style="margin-left: 1rem; margin-right: 1rem;">
    <nav class="navbar navbar-expand-md navbar-dark bg-dark">
        <a class="navbar-brand red-after" href="{{ route('home') }}">
            <b>Cinema Blu-ray</b>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto">
                @if(Auth::check() && Auth::user()->isAdmin == 1)
                    <li class="nav-item">
                        <a class="nav-link red-after" href="{{ route('editMovies') }}">Edycja Filmów</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link red-after" href="{{ route('editUsers') }}">Edycja użytkowników</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link red-after" href="{{ route('loans') }}"><strong>ZAMÓWIENIA</strong></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link red-after" href="{{ route('support') }}">Zgłoszenia problemów</a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link red-after" href="{{ route('movies.index') }}">Nasze Wszystkie filmy</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link red-after" href="{{ route('regulamin') }}">Regulamin</a>
                    </li>
                @endif
            </ul>
            <div>
                @guest
                <a href="{{ route('login') }}" class="btn btn-block custom-btn m-2"><b>Zaloguj</b></a>
                @else
                <a href="{{ route('loans.show') }}" class="btn btn-block custom-btn m-2"><b>Koszyk</b></a>
                <a href="/users/{{ Auth::id() }}" class="btn btn-block custom-btn m-2"><b>Twój profil</b></a>
                <a href="{{ route('logout') }}" class="btn btn-block custom-btn m-2"><b>Wyloguj</b></a>
                @endguest
            </div>
        </div>
    </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
