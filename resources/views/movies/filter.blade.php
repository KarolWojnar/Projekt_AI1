@include('layouts.header')
@include('layouts.css')

<div class="container text-white w-50">
    <form action="{{ route('movies.filter') }}" method="GET" class="row">
        <div class="form-group col-md-6">
            <label for="genre">Gatunek</label>
            <select name="genre" id="genre" class="form-control">
                <option value="">Wszystkie</option>
                @foreach ($categories as $category)
                    @if ($category->id == $idSelected)
                    <option selected value="{{$category->id}}">{{$category->genre}}</option>
                    @else
                    <option value="{{$category->id}}">{{$category->genre}}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-6">
            <label for="sort_by">Sortuj według</label>
            <select name="sort_by" id="sort_by" class="form-control">
                <option value="">Brak sortowania</option>
                <option @if ($idSorted === 'release1') selected @endif value="release1">Od najmłodszego</option>
                <option @if ($idSorted === 'release2') selected @endif value="release2">Od najstarszego</option>
                <option @if ($idSorted === 'rate1') selected @endif value="rate1">Ocena rosnąco</option>
                <option @if ($idSorted === 'rate2') selected @endif value="rate2">Ocena malejąco</option>
                <option @if ($idSorted === 'length1') selected @endif value="length1">Długość filmu malejąca</option>
                <option @if ($idSorted === 'length2') selected @endif value="length2">Długość filmu rosnąca</option>
            </select>
        </div>
        <div class="form-group col-12 text-center">
            <button type="submit" class="btn custom-btn m-2">Filtruj</button>
        </div>
    </form>
    <div class="d-flex justify-content-center m-3">
        <form class="form-inline" role="search" action="{{ route('movies.search') }}" method="GET">
            <div class="input-group">
                <input class="form-control" type="search" name="search" placeholder="Wpisz tytuł, aby wyszukać..." required aria-label="Search" value="">
                <div class="input-group-append">
                    <button class="btn custom-btn m-2" type="submit">Szukaj</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="container">
    <div class="row d-flex flex-wrap justify-content-center">
        @if ($movies->count() == 0)
        <h1 class="text-white">Nie ma takich filmów</h1>
        @endif
        @foreach($movies as $movie)
        <div class="card bg-dark2 text-white m-3" style="width: 18rem;">
            <img src="{{ route('movies.image', ['id' => $movie->id]) }}" class="card-img-top" alt="">
            <div class="card-body">
                <h6 class="card-title text-danger2"><b>{{ $movie->title }}</b></h6>
            </div>
            <ul class="list-group list-group-flush bg-secondary">
                <li class="list-group-item bg-dark2 text-white">Reżyser: <b>{{ $movie->director }}</b></li>
                <li class="list-group-item bg-dark3">Rok premiery: <b>{{ $movie->release }}</b></li>
                <li class="list-group-item bg-dark3">Ocena: <b class="text-white">{{ $movie->rate }}</b></li>
            </ul>
            <div class="card-body bg-dark mb-1">
                <a href="/movie/{{ $movie->id }}" class="btn btn-block custom-btn"><b>Przejdź do filmu</b></a>
            </div>
        </div>
        @endforeach
    </div>
</div>
<div id="support-container">
    @include('layouts.support')
</div>
