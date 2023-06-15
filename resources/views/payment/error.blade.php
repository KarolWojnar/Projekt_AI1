@include('layouts.css')
@include('layouts.header')
    <div class="container text-white">
        <h1 class="text-danger">Błąd płatności</h1>
        <p>Przepraszamy, wystąpił błąd podczas przetwarzania płatności.</p>
        <p>{{ session('error') }}</p>
        <a href="/users/{{ Auth::id() }}" class="btn custom-btn">Opłać na swoim profilu</a>
    </div>

    <div id="support-container">
        @include('layouts.support')
    </div>
