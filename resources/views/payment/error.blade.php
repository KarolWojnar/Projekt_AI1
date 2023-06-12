@include('layouts.css')
@include('layouts.header')
    <div class="container text-white">
        <h1>Błąd płatności</h1>
        <p>Przepraszamy, wystąpił błąd podczas przetwarzania płatności.</p>
        <p class="text-danger">Błąd: {{ session('error') }}</p>
    </div>

