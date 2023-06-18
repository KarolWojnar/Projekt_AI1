@include('layouts.css')
@include('layouts.header')

<div class="container text-white">
    <h1>Płatność zakończona sukcesem!</h1>
    <p>Dziękujemy za dokonanie płatności.</p>
    @if(count($latestLoanMovies) > 0)
        <h2>Filmy z ostatniego wypożyczenia:</h2>
        <div class="row">
            @foreach($latestLoanMovies as $movie)
                <div class="col-md-3">
                    <div class="card bg-dark text-white m-3">
                        <img src="{{ route('movies.image', ['id' => $movie->id]) }}" class="card-img-top" alt="">
                        <div class="card-body">
                            <h6 class="card-title text-danger2"><b>{{ $movie->title }}</b></h6>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
    <h2>Zaraz wrócisz na stronę główną.</h2>
</div>


<div id="support-container">
    @include('layouts.support')
</div>

<script>
    setTimeout(function() {
        window.location.href = "/";
    }, 5000); // Przekierowanie po 5 sekundach (5000 milisekund)
</script>
