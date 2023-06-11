<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('header.name', 'Laravel') }}</title>
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
<body class="bg-dark m-3">
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm">
            <div class="container">
                <a class="navbar-brand red-after" href="{{ route('home') }}">
                    <b>Cinema Blu-ray</b>
                </a>
<<<<<<< HEAD
=======

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto">

                    </ul>
                </div>
                <div>
                    @guest
                        <a href="{{ route('login') }}" class="btn btn-block custom-btn"><b>Zaloguj</b></a>
                @else
                    @if (!Request::capture()->is('users/' . Auth::id()))
                        <a href="/users/{{ Auth::id() }}" class="w-40 h-100 m-2 btn btn-block custom-btn"><b>Twój profil</b></a>
                    @endif
                        <a href="{{ route('logout') }}" class=" btn btn-block custom-btn"><b>Wyloguj</b></a>
                @endguest
                </div>
>>>>>>> 58022ff019aad8013f69d3b8f9cf83223e4d054c
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