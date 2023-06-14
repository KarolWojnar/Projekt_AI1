@include('layouts.css')
<body class="bg-dark m-3 text-white w-50 mx-auto">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h2 class="mb-4">Formularz płatności</h2>
                <form action="{{route('process_payment')}}" method="POST" >
                    @csrf
                    <div class="mb-3">
                        <label for="price" class="form-label">Cena:</label><br>
                        <input type="text" class="orm-control-static lead" onfocus="this.blur()" value="{{ $totalPrice }}" name="totalPrice" style="display: none;border: none;"><p class="form-control-static lead"><strong>{{ $totalPrice }} zł</strong></p>
                    </div>
                    <div class="mb-3">
                        <label for="start" class="form-label">Początek wypożyczenia:</label>
                        <input type="text" class="orm-control-static lead" onfocus="this.blur()" value="{{ $startDate }}" name="startDate" style="display: none;border: none;"><p class="form-control-static lead"><strong>{{ $startDate }}</strong></p>
                    </div>
                    <div class="mb-3">
                        <label for="end" class="form-label">Koniec wypożyczenia:</label>
                        <input type="text" class="orm-control-static lead" onfocus="this.blur()" value="{{ $endDate }}" name="endDate" style="display: none;border: none;"><p class="form-control-static lead"><strong>{{ $endDate }}</strong></p>
                    </div>
                    <div class="mb-3">
                        <label for="movies" class="form-label">Filmy:</label>
                            <p class="form-control-static lead">
                                @foreach ($cart as $movie)
                                <strong>"{{ $movie->title }}"{{ $loop->last ? '' : ',' }}</strong>
                                @endforeach
                            </p>

                    </div>
                    <div id="card-element" class="form-control"></div>
                    <div id="card-errors" class="invalid-feedback"></div>
                    <button type="submit" class="btn custom-btn w-50"><strong>Zapłać</strong></button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        var stripe = Stripe('pk_test_51NI4MxBaqWYTYCZyr9BClR3bjt79mH6OD8RKCwYP8aKyhjgW5UfK1rlSQlDq3juSw98hB2Cn24XMI2TOrQWqfBkK00nseW95bf');
        var elements = stripe.elements();
        var cardElement = elements.create('card');
        cardElement.mount('#card-element');

        var form = document.querySelector('form');

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
</body>

<div id="support-container">
    @include('layouts.support')
</div>
