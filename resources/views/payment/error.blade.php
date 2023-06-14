@include('layouts.css')
@include('layouts.header')
    <div class="container text-white">
        <h1>Błąd płatności</h1>
        <p>Przepraszamy, wystąpił błąd podczas przetwarzania płatności.</p>
        <a href="{{ route('loans.show') }}" class="btn custom-btn">Powrót do koszyka</a>
    </div>

    <div id="support-container">
        @include('layouts.support')
    </div>
