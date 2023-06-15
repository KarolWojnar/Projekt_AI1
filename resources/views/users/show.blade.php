@include('layouts.header')
@include('layouts.css')

<div class="container mt-5">
    <div class="card">
        <div class="card-header bg-dark text-white">
            <h1>{{ $user->first_name }} {{ $user->last_name }}</h1>
        </div>
        <div class="card-body bg-dark text-white">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Email:</strong> {{ $user->email }}</p>
                    <p><strong>Adres: </strong>{{ $user->address }}, {{$user->city}}</p>
                    @if ($user->late_fee > 0)
                        <div class="alert alert-info">
                            <h3 class="text-danger">Masz {{ $user->late_fee }} zł długu</h3>
                            <div class="row justify-content-center">
                                <div class="col-md-8">
                                    <form action="{{route('processPayment_lateFee')}}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="price" class="form-label">Opłata:</label>
                                            <input type="text" class="form-control-static lead" onfocus="this.blur()" value="{{ $user->late_fee }}" name="totalPrice" style="display: none;border: none;">
                                        </div>
                                        <div id="card-element" class="form-control"></div>
                                        <div id="card-errors" class="invalid-feedback"></div>
                                        <button type="submit" class="btn btn-danger w-50 m-2"><strong>Zapłać</strong></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                    <a class="btn custom-btn" href="{{ route('users.edit', ['id' => $user->id]) }}">Edytuj dane</a>
                </div>
                <div class="col-md-6">
                    <div class="text-white">
                        @php
                        $i = 0;
                        @endphp
                        @foreach ($loans as $loan)
                        @if ($loan->status != 'Zwrócone')
                        @php
                        $i++;
                        @endphp
                        @endif
                        @endforeach
                        @if ($i == 0)
                        @else
                        <h3>Aktualne wypożyczenia:</h3>
                        <ul class="list-group">
                            @foreach ($loans as $loan)
                            @if ($loan->user_id == $user->id && $loan->status != 'Zwrócone')
                            <li class="list-group-item rounded m-2" style="opacity: 0.6">
                                <strong>Data wypożyczenia:</strong> {{ $loan->start_loan }} <br>
                                <strong class="text-danger">Ustalona data zwrotu:</strong> {{ $loan->end_loan }} <br>
                                @if (strtotime(date('Y-m-d')) > strtotime($loan->end_loan))
                                <h4 class="text-dark bg-danger">Spóźniasz się z oddaniem</h4><br>
                                @endif
                                <strong>Filmy w wypożyczeniu:</strong><br>
                                @foreach ($loan->movies as $movie)
                                "{{ $movie->title }}"<br>
                                @endforeach
                                <strong>Status:</strong> {{ $loan->status }}
                                @if ($loan->status == 'Nieopłacone')
                                <div class="row justify-content-center">
                                    <div class="col-md-8">
                                        <form action="{{ route('processPayment_late') }}" method="POST" class="w-100">
                                            @csrf
                                            <div class="mb-3">
                                                <input type="text" class="form-control-static lead" onfocus="this.blur()" value="{{ $loan->price }}" name="totalPrice" style="display: none;border: none;"><p class="form-control-static lead"><strong>{{ $loan->price }} zł</strong></p>
                                                <input type="text" class="form-control-static lead" onfocus="this.blur()" value="{{ $loan->id }}" name="loanId" style="display: none;border: none;">
                                            </div>
                                            <div id="card-element" class="form-control"></div>
                                            <div id="card-errors" class="invalid-feedback"></div>
                                            <div class="d-flex justify-content-between">
                                                <button type="submit" class="btn custom-btn w-45 m-2"><strong>Zapłać</strong></button>
                                                <a href="" class="btn btn-danger w-45 m-2"><strong>Anuluj wypożyczenie</strong></a>
                                            </div>
                                            <strong class="text-danger">Jeśli nie opłacisz zamówienia do daty startu wypożczenia filmy ponownie trafią do oferty sklepu</strong>
                                        </form>
                                    </div>
                                </div>
                                @endif
                            </li>
                            @endif
                            @endforeach
                        </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-5 text-white">
        <div class="">
            @if ($loans->count() > 0)
                <h3>Historia filmów które wypożyczyłeś:</h3>
                <div class="table-responsive">
                    <table class="table table-striped text-white">
                        <thead>
                            <tr>
                                <th>Tytuł filmu</th>
                                <th>Data wypożyczenia</th>
                                <th>Akcje</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $addedMovies = [];
                            @endphp
                            @foreach ($loans as $loan)
                                @foreach ($loan->movies as $movie)
                                    @if (!in_array($movie->id, $addedMovies))
                                    <tr>
                                        <td class="text-white">
                                            {{ $movie->title }}
                                        </td>
                                        <td class="text-white">{{ $loan->start_loan }}</td>
                                        <td>
                                            <a href="#" class="btn btn-secondary custom-btn m-1" onclick="toggleEditPanel(event, {{ $movie->id }})">Dodaj swoją opinię o filmie</a>
                                            <li id="edit-panel-{{ $movie->id }}" class="list-group-item bg-dark text-white edit-panel" style="display: none;">

                                                <form action="{{ route('opinions.store') }}" method="POST">
                                                    @csrf
                                                    <div class="form-group m-1">
                                                        <input type="hidden" value="{{ $movie->id }}" name="movie_id">
                                                        <textarea class="form-control" name="content" rows="3" placeholder="Dodaj opinię"></textarea>
                                                    </div>
                                                    <button type="submit" class="btn btn-secondary custom-btn m-1 w-30">Zapisz</button>
                                                </form>
                                            </li>
                                        </td>
                                    </tr>
                                        @php
                                            $addedMovies[] = $movie->id;
                                        @endphp
                                    @endif
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-white">Nie wypożyczyłeś jeszcze żadnych filmów</p>
            @endif
        </div>
    </div>
</div>

<div id="support-container">
    @include('layouts.support')
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

    function toggleEditPanel(event, movieId) {
        event.preventDefault();
        var editPanel = document.getElementById('edit-panel-' + movieId);
        if (editPanel.style.display === 'none') {
            editPanel.style.display = 'block';
        } else {
            editPanel.style.display = 'none';
        }
    }

</script>
