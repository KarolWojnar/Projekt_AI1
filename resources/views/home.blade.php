<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Prjekt_AI1</title>
    <link href="css/bootstrap.css" rel="stylesheet">
  </head>
  <body class="bg-dark">
    <nav class="navbar navbar-expand-md navbar-dark bg-dark m-3">
        <a class="navbar-brand red-after nav-link">
            <b>Cinema Blu-ray</b>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                <a class="nav-link red-after" href="#">O nas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link red-after" href="{{ route('regulamin') }}">Regulamin</a>
                </li>
                @if(Auth::check() && Auth::user()->isAdmin)
                    <li class="nav-item">
                        <a class="nav-link red-after" href="{{ route('editMovies') }}">Edycja Filmów</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link red-after" href="{{ route('editUsers') }}">Edycja użytkowników</a>
                    </li>
                @endif
            </ul>
            <div>
                @guest
                    <a href="{{ route('login') }}" class="btn btn-block custom-btn"><b>Zaloguj</b></a>
            @else
                    <a href="/users/{{ Auth::id() }}" class="w-40 h-100 m-2 btn btn-block custom-btn"><b>Twój profil</b></a>
                    <a href="{{ route('logout') }}" class=" btn btn-block custom-btn"><b>Wyloguj</b></a>
            @endguest
            </div>
        </div>
    </nav>

    <div id="carouselExampleInterval" class="carousel slide p-1" data-bs-ride="carousel">
        <div class="carousel-inner">
        <div class="carousel-item active" data-bs-interval="10000">
            <img src="img/background3.jpg" class="d-block w-100 rounded" alt="...">
        </div>
        <div class="carousel-item" data-bs-interval="2000">
            <img src="img/background1.jpg" class="d-block w-100 rounded" alt="...">
        </div>
        <div class="carousel-item">
            <img src="img/background2.jpg" class="d-block w-100 rounded" alt="...">
        </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
        </button>
    </div>
    <div class="d-flex align-items-center justify-content-center">
        <div class="text-center text-white ">
        <h1>Polecane dziś filmy</h1>
        </div>
    </div>
        @php
    $randomIds = DB::table('movies')
        ->where('available', '=', 'dostępny')
        ->inRandomOrder()
        ->limit(5)
        ->select('img_path', 'title', 'release', 'director', 'id')
        ->get();
        @endphp
    @foreach ($randomIds as $movie)
        @php
            $img_path = $movie->img_path;
            $title = $movie->title;
            $release = $movie->release;
            $director = $movie->director;
            $id = $movie->id;
        @endphp
    <div class="d-inline-block card bg-dark2 text-white m-3" style="width: 17rem;">
        <img src="{{ asset($img_path) }}" class="card-img-top" alt="">
        <div class="card-body">
        <h6 class="card-title text-danger2 "><b>{{ $title }}</b></h6>
        <p class="card-text"></p>
        </div>
        <ul class="list-group list-group-flush bg-secondary">
        <li class="list-group-item bg-dark2 text-white">Reżyser: <b>{{ $director }}</b></li>
        <li class="list-group-item bg-dark3">Rok premiery: <b>{{ $release }}</b></li>
        </ul>
        <div class="card-body bg-dark">
        <a href="/movie/{{ $id }}" class="w-100 h-100 btn btn-block custom-btn"><b>Przejdź do filmu</b></a>
        </div>
    </div>
    @endforeach
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
  </body>
</html>
