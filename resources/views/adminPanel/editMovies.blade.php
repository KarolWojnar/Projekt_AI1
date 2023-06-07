@include('layouts.header')
@include('layouts.css')
<div class="container w-100">
    <ul class="list-group">
        @foreach($movies as $key => $movie)
            <li class="list-group-item d-flex justify-content-between align-items-center @if($key % 2 == 1) bg-dark @else bg-dark @endif text-white">
                <div class="text-white">
                    <span class="fw-bold">{{ $movie->id }}</span>
                    <span class="fw-bold">{{ $movie->title }}</span>
                    <span class="">({{ $movie->genre }})</span>
                    <span class="">Released: {{ $movie->release }}</span>
                    <span class="">Premiera: {{ $movie->available }}</span>
                </div>
                <div>
                    <a href="#" class="btn btn-secondary custom-btn">Edytuj</a>
                    <a href="{{ route('movies.delete', ['id' => $movie->id]) }}" class="btn btn-danger custom-btn">Usuń</a>
                </div>
            </li>
        @endforeach
    </ul>
</div>
