@include('layouts.header')
@include('layouts.css')

<div class="card mb-3 bg-dark text-white m-5">
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
                <p class="card-text"><strong>Cena za dzień wypożyczenia: </strong> {{ $movie->pricePerDay }} zł</p>
                <div class="d-flex justify-content-center">
                    @if ($movie->available == 'dostępny')
                        <form action="{{ route('movies.show', ['id' => $movie->id]) }}" method="POST">
                            @csrf
                            @guest
                                <a href="{{ route('login') }}" class="btn btn-block custom-btn"><b>Zaloguj się by wypożyczyć "{{ $movie->title }}"</b></a>
                            @else
                                @if ($user->late_fee == 0)
                                    @php
                                    $isInCart = false;
                                    foreach ($cart as $cartMovie) {
                                        if ($cartMovie->id == $movie->id) {
                                            $isInCart = true;
                                            break;
                                        }
                                    }
                                    @endphp
                                    @if ($isInCart)
                                    <p>Film "{{ $movie->title }}" znajduje się już w koszyku.</p>
                                    @else
                                    <a href="{{ route('addToCart', ['id' => $movie->id]) }}" class="btn btn-block custom-btn"><b>Dodaj do koszyka film "{{ $movie->title }}"</b></a>
                                    @endif
                                @else
                                    <a href="" class="text-danger2">Aby dodać do koszyka film najpierw opłać karę.</h5>
                                @endif
                            @endguest
                        </form>
                    @else
                        <p class="card-text"><strong>Przepraszamy, film jest aktualnie niedostępny</strong></p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<div id="support-container">
    @include('layouts.support')
</div>
