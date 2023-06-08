@include('layouts.header')
@include('layouts.css')
<div class="card mb-3 bg-dark text-white">
    <div class="row g-0">
      <div class="col-md-3">
        <img src="{{ asset($movie->img_path) }}" class="img-fluid h-40" alt="{{ $movie->title }}">
      </div>
      <div class="col-md-8">
        <div class="card-body">
          <h3 class="card-title">{{ $movie->title }}</h3>
          <p class="card-text"><strong>Gatunek:</strong> {{ $movie->genre }}</p>
          <p class="card-text"><strong>Opis:</strong> {{ $movie->description }}</p>
          <p class="card-text"><strong>Reżyser:</strong> {{ $movie->director }}</p>
          <p class="card-text"><strong>Rok premiery:</strong> {{ $movie->release }}</p>
          <p class="card-text"><strong>Czas trwania:</strong> {{ $movie->longTime }} minut</p>
          <p class="card-text"><strong>Ocena:</strong> {{ $movie->rate }}</p>
          <div class="d-flex justify-content-center">
            @if ($movie->available == 'dostępny')
                <a href="#" class="btn btn-secondary custom-btn w-50">Wypożycz film "{{ $movie->title }}"</a>
            @else
            <p class="card-text"><strong>Przepraszamy, film jest aktualnie niedostępny</strong></p>
            @endif
        </div>
        </div>
      </div>
    </div>
  </div>


