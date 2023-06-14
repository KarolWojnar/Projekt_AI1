@include('layouts.header')
@include('layouts.css')

<div class="container text-white w-50">
    <form action="{{ route('movies.filter') }}" method="GET" class="row">
        <div class="form-group col-md-6">
            <label for="genre">Gatunek</label>
            <select name="genre" id="genre" class="form-control">
                <option value="">Wszystkie</option>
                <option value="Biograficzny">Biograficzny</option>
                <option value="Dramat">Dramat</option>
                <option value="Familijny">Familijny</option>
                <option value="Fantasy">Fantasy</option>
                <option value="Gangsterski">Gangsterski</option>
                <option value="Kryminał">Kryminał</option>
                <option value="Przygodowy">Przygodowy</option>
                <option value="Psychologiczny">Psychologiczny</option>
                <option value="Surrealistyczny">Surrealistyczny</option>
                <option value="Thriller">Thriller</option>
                <option value="Western">Western</option>
                <option value="Wojenny">Wojenny</option>
            </select>
        </div>
        <div class="form-group col-md-6">
            <label for="sort_by">Sortuj według</label>
            <select name="sort_by" id="sort_by" class="form-control">
                <option value="">Brak sortowania</option>
                <option value="release1">Od najmłodszego</option>
                <option value="release2">Od najstarszego</option>
                <option value="rate1">Ocena rosnąco</option>
                <option value="rate2">Ocena malejąco</option>
                <option value="length1">Długość filmu malejąca</option>
                <option value="length2">Długość filmu rosnąca</option>
            </select>
        </div>
        <div class="form-group col-30 text-center">
            <button type="submit" class="btn btn-secondary custom-btn m-2">Filtruj</button>
        </div>
    </form>
    <div class="d-flex justify-content-center">
        <form class="d-flex justify-content-center" role="search" action="{{ route('movies.filter') }}" method="GET">
            <input class="form-control me-2" type="search" name="search" placeholder="Wpisz tytuł, aby wyszukać..." aria-label="Search">

            <button class="btn btn-outline-success" type="submit">Szukaj</button>
        </form>
    </div>
</div>

<div class="container">
    <div class="row d-flex flex-wrap justify-content-center">
        @foreach($movies as $movie)
        <div class="d-inline-block card bg-dark2 text-white m-3" style="width: 18rem;">
            <img src="{{ asset($movie->img_path) }}" class="card-img-top" alt="">
            <div class="card-body">
            <h6 class="card-title text-danger2"><b>{{ $movie->title }}</b></h6>
            </div>
            <ul class="list-group list-group-flush bg-secondary">
            <li class="list-group-item bg-dark2 text-white">Reżyser: <b>{{ $movie->director }}</b></li>
            <li class="list-group-item bg-dark3">Rok premiery: <b>{{ $movie->release }}</b></li>
            <li class="list-group-item bg-dark3">Ocena: <b class="text-white">{{ $movie->rate }}</b></li>
            </ul>
            <div class="card-body bg-dark mb-1">
            <a href="/movie/{{ $movie->id }}" class="w-100 h-100 btn btn-block custom-btn"><b>Przejdź do filmu</b></a>
            </div>
        </div>
        @endforeach
    </div>
</div>
<div id="support-container">
    @include('layouts.support')
</div>
