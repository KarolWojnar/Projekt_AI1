@extends('layouts.header')

@section('content')
<!DOCTYPE html>
<html>
<head>
    <title>Regulamin</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Prjekt_AI1</title>
    <link href="css/bootstrap.css" rel="stylesheet">
    <style>
        ul>li {
            font-weight: lighter;
            color: rgba(255, 255, 255, 0.603);
        }
    </style>
</head>
<body>
    <h1>Regulamin</h1>
    <ol class="text-danger2 fw-bold">
        <li >Rejestracja
            <ul>
                <li>Każdy nowy użytkownik musi się zarejestrować, aby korzystać z usług wypożyczalni filmów Blu-ray.</li>
                <li>W trakcie rejestracji użytkownik musi podać poprawne dane osobowe, w tym imię, nazwisko, adres zamieszkania i adres e-mail.</li>
                <li>Użytkownik jest odpowiedzialny za aktualizację swoich danych osobowych w przypadku zmiany.</li>
            </ul>
        </li>

        <li>Wybór filmów
            <ul>
                <li>Użytkownik może wybierać filmy dostępne w ofercie wypożyczalni.</li>
                <li>Każdy film jest oznaczony z góry ustaloną ceną wypożyczenia.</li>
                <li>Użytkownik może dodać wybrane filmy do koszyka w celu złożenia zamówienia.</li>
            </ul>
        </li>

        <li>Zamówienie
            <ul>
                <li>Użytkownik musi złożyć zamówienie na wybrane filmy poprzez proces składania zamówienia na stronie internetowej wypożyczalni.</li>
                <li>Zamówienie wymaga potwierdzenia, a użytkownik otrzymuje informacje dotyczące opłat i terminu wypożyczenia.</li>
            </ul>
        </li>

        <li>Opłaty
            <ul>
                <li>Opłata za wypożyczenie filmu jest naliczana na podstawie ustalonej ceny za każdy film.</li>
                <li>Użytkownik jest zobowiązany do zapłacenia opłaty wypożyczenia przed wysyłką filmu.</li>
                <li>Użytkownik może ponieść dodatkowe opłaty za przetrzymanie filmu po terminie zwrotu. Określona jest kara za każdy dzień opóźnienia.</li>
            </ul>
        </li>

        <li>Dostawa i zwrot
            <ul>
                <li>Wypożyczalnia jest odpowiedzialna za dostarczenie zamówionych filmów do użytkownika.</li>
                <li>Użytkownik jest zobowiązany do zwrotu wypożyczonych filmów przed upływem ustalonego terminu.</li>
                <li>Użytkownik jest odpowiedzialny za zwrot filmów w stanie nienaruszonym i w oryginalnym opakowaniu.</li>
            </ul>
        </li>

        <li>Kary za opóźnienie
            <ul>
                <li>Użytkownik ponosi karę za każdy dzień opóźnienia w zwrocie filmu.</li>
                <li>Wysokość kary jest ustalana na podstawie ustalonej stawki za dzień opóźnienia.</li>
                <li>Kary za opóźnienie są naliczane do momentu, gdy film zostanie zwrócony.</li>
            </ul>
        </li>

        <li>Utrata lub uszkodzenie filmu
            <ul>
                <li>Użytkownik jest odpowiedzialny za utratę lub uszkodzenie wypożyczonego filmu.</li>
                <li>W przypadku utraty lub znacznego uszkodzenia filmu użytkownik jest zobowiązany do pokrycia kosztów zastąpienia lub naprawy.</li>
            </ul>
        </li>

        <li>Zakończenie umowy
            <ul>
                <li>Użytkownik może wypowiedzieć umowę wypożyczenia filmów w dowolnym momencie.</li>
                <li>W przypadku zakończenia umowy użytkownik jest zobowiązany do zwrotu wszystkich wypożyczonych filmów.</li>
            </ul>
        </li>

        <li>Zmiany w regulaminie
            <ul>
                <li>Wypożyczalnia zastrzega sobie prawo do wprowadzenia zmian w regulaminie.</li>
                <li>Użytkownik zostanie poinformowany o zmianach regulaminu poprzez powiadomienie na stronie internetowej.</li>
            </ul>
        </li>

        <li>Postanowienia końcowe
            <ul>
                <li>W przypadku sporu, wszelkie kwestie są rozpatrywane zgodnie z obowiązującym prawem.</li>
                <li>Wypożyczalnia nie ponosi odpowiedzialności za jakiekolwiek straty lub szkody wynikłe z korzystania z usług. Użytkownik korzysta z usług na własne ryzyko.</li>
            </ul>
        </li>
    </ol>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
@endsection
