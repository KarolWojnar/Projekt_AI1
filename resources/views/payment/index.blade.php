@include('layouts.css')
<body class="bg-dark m-3 text-white w-50 mx-auto">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h2 class="mb-4">Formularz płatności</h2>
                <form action="/process_payment" method="POST" id="payment-form">
                    @csrf
                    <div class="mb-3">
                        <label for="price" class="form-label">Cena:</label>
                        <p class="form-control-static lead"><strong>{{ $totalPrice }} zł</strong></p>
                    </div>
                    <div class="mb-3">
                        <label for="start" class="form-label">Początek wypożyczenia:</label>
                        <p class="form-control-static lead"><strong>{{ $startDate }}</strong></p>
                    </div>
                    <div class="mb-3">
                        <label for="end" class="form-label">Koniec wypożyczenia:</label>
                        <p class="form-control-static lead"><strong>{{ $endDate }}</strong></p>
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
                    <div class="mb-3">
                        <label for="blik-code" class="form-label">Kod BLIK:</label>
                        <input type="text" id="blik-code" name="blikCode" class="form-control">
                        <div id="blik-errors" class="invalid-feedback"></div>
                    </div>
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

        var cardErrors = document.getElementById('card-errors');
        var blikCodeInput = document.getElementById('blik-code');

        cardElement.addEventListener('change', function(event) {
            if (event.error) {
                cardErrors.textContent = event.error.message;
            } else {
                cardErrors.textContent = '';
            }
        });

        var form = document.getElementById('payment-form');

        form.addEventListener('submit', function(event) {
            event.preventDefault();

            if (blikCodeInput.value) {
                // Jeśli kod BLIK jest wprowadzony, przekazujemy tylko kod BLIK do serwera
                var formData = new FormData();
                formData.append('blikCode', blikCodeInput.value);

                // Wyślij dane płatności BLIK do serwera
                fetch('/process_payment', {
                    method: 'POST',
                    body: formData
                })
            } else {
                // W przeciwnym razie, jeśli kod BLIK nie jest wprowadzony, używamy tokenu płatności Stripe

                stripe.createToken(cardElement).then(function(result) {
                    if (result.error) {
                        cardErrors.textContent = result.error.message;
                    } else {
                        // Przesyłanie tokenu płatności do serwera
                        stripeTokenHandler(result.token);
                    }
                });
            }
        });

        function stripeTokenHandler(token) {
            // Wysyłanie tokenu płatności do serwera i przekierowanie do strony potwierdzenia
            var form = document.getElementById('payment-form');
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            cardErrors.textContent = token.error.message;
            form.appendChild(hiddenInput);
            form.submit();
        }
    </script>
</body>
</html>
