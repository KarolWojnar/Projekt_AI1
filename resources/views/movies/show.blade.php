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
                        @if ($loans->count() > 0)
                            <p class="text-danger text-center"><strong>Nie możesz wypożyczyć filmu ponieważ masz nieopłacone lub niezwrócone na czas wypożycznie. <br> Rozwiąż te problemy a możliwość wypożyczenia wróci.</strong></p>
                        @else
                        @if ($user && $user->late_fee > 0)
                            <div class="alert alert-info">
                                <h3 class="text-danger">Masz {{ $user->late_fee }} zł kary. Zanim coś wypożyczysz, najpierw zapłać karę.</h3>
                                <div class="row justify-content-center">
                                    <div class="col-md-8">
                                        <form action="{{ route('processPayment_lateFee') }}" method="POST" id="processPayment_lateFee">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="price" class="form-label">Opłata:</label>
                                                <input type="text" class="form-control-static lead" onfocus="this.blur()" value="{{ $user->late_fee }}" name="totalPrice" style="display: none;border: none;">
                                            </div>
                                            <div id="card-element" class="form-control" data-stripe-key="{{ env('STRIPE_KEY') }}"></div>
                                            <div id="card-errors" class="invalid-feedback"></div>
                                            <button type="submit" class="btn btn-danger w-50 m-2"><strong>Zapłać</strong></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @else
                            <form action="{{ route('movies.show', ['id' => $movie->id]) }}" method="POST">
                                @csrf
                                @guest
                                    <a href="{{ route('login') }}" class="btn btn-block custom-btn"><b>Zaloguj się, aby wypożyczyć "{{ $movie->title }}"</b></a>
                                @else
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
                                @endguest
                            </form>
                        @endif
                        @endif
                    @else
                        <p class="card-text"><strong>Przepraszamy, film jest aktualnie niedostępny</strong></p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card mb-3 bg-dark text-white m-5">
    <div class="card-body">
        <h4 class="card-title">Opinie osób której już obejżały</h4>
        <hr>
        @foreach ($movie->opinions as $opinion)
            <div class="card my-2">
                <div class="card-body text-white">
                    <h6 class="card-subtitle mb-2 text-white"><strong>{{ $opinion->user->first_name }}</strong></h6>
                    <p class="card-text">{{ $opinion->content }}</p>
                </div>
                <div class="card-footer">
                    <small class="text-black">{{ $opinion->updated_at }}</small>
                </div>
            </div>
        @endforeach
    </div>
</div>



<div id="support-container">
    @include('layouts.support')
</div>

<script src="https://js.stripe.com/v3/"></script>
<script>
    var stripeKey = document.getElementById('card-element').getAttribute('data-stripe-key');
    var stripe = Stripe(stripeKey);
    var elements = stripe.elements();
    var cardElement = elements.create('card');
    cardElement.mount('#card-element');

    var form = document.getElementById('processPayment_lateFee');

    form.addEventListener('submit', function(event) {
        event.preventDefault();

        stripe.createToken(cardElement).then(function(result) {
        if (result.error) {
            // Obsługa błędu tokenizacji
            console.error(result.error.message);
        } else {
            // Pobranie tokenu płatności
            var token = result.token.id;

            // Dodanie tokenu do formularza
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token);
            form.appendChild(hiddenInput);

            // Wysłanie formularza
            form.submit();
        }
        });
    });

</script>
