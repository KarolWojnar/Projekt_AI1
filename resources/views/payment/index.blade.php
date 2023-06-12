<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('header.name', 'Laravel') }}</title>
    <link href="css/bootstrap.css" rel="stylesheet">
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <style>
    .red-after:hover {
        color: rgba(var(--bs-danger-rgb), var(--bs-bg-opacity)) !important;
    }
    </style>
</head>
<body class="bg-dark m-3 text-white w-25 mx-auto" >
    <form action="/process_payment" method="POST" id="payment-form">
        @csrf
        <div class="form-row ">

        <div class="form-row">
          <label for="blik-code">
            Kod BLIK
          </label>
          <input type="text" id="blik-code" name="blikCode">
        </div>
        <div id="blik-errors" role="alert"></div>
    </div>

        <button type="submit">Zapłać</button>
      </form>
      <script src="https://js.stripe.com/v3/"></script>
</body>
<script>
var stripe = Stripe('pk_live_51NI4MxBaqWYTYCZy2UJoE1PuB0WBPpd2fnBKsesGj0YE320fEfNhINNxezBRAdr7utuTS1Kt0bdxqGQxZoD1hFlO00hawooq3J');

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
    .then(function(response) {
      // Obsłuż odpowiedź serwera (np. wyświetl komunikat o sukcesie lub błędzie)
    })
    .catch(function(error) {
      // Obsłuż błąd żądania
    });
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
  form.appendChild(hiddenInput);
  form.submit();
}

</script>
