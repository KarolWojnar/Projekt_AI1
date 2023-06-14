@include('layouts.css')
@include('layouts.header')
<div class="container">
    <div class="row text-white">
        @if (empty($cart))
        <h1>Twój koszyk jest pusty</h1>
        @else
        <div class="text-white text-center">
            <div id="formHide" style="display: block;">
                <h2 class="text-dark bg-danger">ZANIM WYPOŻYCZYSZ</h2>
                <h6>Czy Twoje dane adresowe są poprawnie podane na profilu?</h6>
                <div class="text-white M-AUTO">
                    <button id="yes" class="btn custom-btn mt-3 col-lg-4" onclick="setEnableLoan(event, {{ $user->id }})">TAK</button>
                    <a class="btn custom-btn mt-3 col-lg-4" onclick="toggleEditPanel(event, {{ $user->id }})">SPRAWADŹ</a>
                </div>
                <li id="edit-panel-{{ $user->id }}" class="list-group-item bg-dark text-white edit-panel w-50 mx-auto" style="display: none;">

                    <form action="{{ route('users.update2', ['id' => $user->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="address">Adres</label>
                            <input type="text" class="form-control" id="address" name="address" value="{{ $user->address }}">
                        </div>
                        <div class="form-group">
                            <label for="city">Miasto</label>
                            <input type="text" class="form-control" id="city" name="city" value="{{ $user->city }}">
                        </div>
                        <button type="submit" class="btn btn-secondary custom-btn m-2 w-30" id="showLoanOption">Zmień</button>
                    </form>
                </li>
            </div>
        </div>
        <div class="">
            <div class="text-center">
                <form method="post" action="{{route('toPayment')}}" >
                    @csrf
                    <div class="row justify-content-center">
                        @php
                        $minDate = now()->addDay(1)->toDateString();
                        $maxDate = now()->addDays(14)->toDateString();
                        @endphp
                        <h3>Witaj {{ $user->first_name }}. Twoje filmy to:</h3>
                        <div class="container">
                            <div class="row d-flex flex-wrap justify-content-center">
                                @foreach ($cart as $movie)
                                <div class="d-inline-block card bg-dark2 text-white m-2" style="width: 17rem">
                                    <h6>"{{ $movie->title }}"</h6>
                                    <img src="{{ asset($movie->img_path) }}" class="img-fluid" alt="{{ $movie->title }}">
                                    <p class="text-small">Cena za dzień: {{ $movie->pricePerDay }} zł</p>
                                        <a href="{{ route('deleteFromCart', ['id' => $movie->id]) }}" class="btn custom-btn mb-100"><b>Usuń produkt</b></a>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @if ($sum > 1)
                    <h5 class="text-danger2">Za wypożyczenie {{$sum}} filmów dostajesz {{$prom*100}}% zniżki!</h5>
                    @endif
                    <div class="row" id="rent" style="height: 15rem">
                        <div style="display: none;" id="showMe" class="col-lg-6">
                            <div class="form-group w-50 mx-auto mt-3">
                                <label for="startDate">Data początku wypożyczenia:</label>
                                <input type="date" id="startDate" name="startDate" value="" class="form-control" min="{{ $minDate }}" max="{{ date('Y-m-d', strtotime('+7 days')) }}" required>
                            </div>
                            <div id="endDateWrapper" class="form-group w-50 mx-auto" style="display: none;">
                                <label for="endDate">Data końca wypożyczenia:</label>
                                <input type="date" id="endDate" name="endDate" value="" class="form-control" min="{{ $minDate }}" required>
                            </div>
                            <button type="button" id="checkPriceBtn" class="btn custom-btn mt-3 mx-auto" disabled style="pointer-events: none; cursor: default;">Sprawdź cenę</button>
                        </div>
                        <div class="col-lg-6 mt-auto mb-auto">
                            <input type="text" id="priceResult" class="h3 bg-dark w-100 text-center" onfocus="this.blur()" name="priceResult" style="display: none;border: none;" readonly>
                            <input type="text" id="priceResult2" onfocus="this.blur()" name="priceResult2" style="display: none;border: none;" readonly>
                            <button type="submit" id="rentMovieBtn" class="btn custom-btn mt-3 mx-auto" style="display: none;" disabled>Przejdź do płatności</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @endif
    </div>
</div>
</div>
    <div id="totalPrice" data-total-price="{{ $totalPrice }}"></div>
</div>
<script>
function setEnableLoan(event, userId) {
    event.preventDefault();
    document.getElementById('rentMovieBtn').removeAttribute('disabled');
}

    document.getElementById('startDate').addEventListener('change', function() {
        var selectedStartDate = new Date(this.value);
        var nextDay = new Date(selectedStartDate.getTime() + (24 * 60 * 60 * 1000));
        var formattedNextDay = nextDay.toISOString().split('T')[0];

        var maxDate = new Date(selectedStartDate.getTime() + (14 * 24 * 60 * 60 * 1000));
        var formattedMaxDate = maxDate.toISOString().split('T')[0];

        document.getElementById('endDate').min = formattedNextDay;
        document.getElementById('endDate').max = formattedMaxDate;

        document.getElementById('endDateWrapper').style.display = 'block';
        this.setAttribute('readonly', 'readonly');

        document.getElementById('endDate').addEventListener('change', function() {
            var selectedEndDate = new Date(this.value);

            if (selectedEndDate) {
                document.getElementById('checkPriceBtn').removeAttribute('disabled');
                document.getElementById('checkPriceBtn').style.pointerEvents = 'auto';
                document.getElementById('checkPriceBtn').style.cursor = 'pointer';
            }
        });
    });

    function toggleEditPanel(event, movieId) {
        event.preventDefault();
        var editPanel = document.getElementById('edit-panel-' + movieId);
        if (editPanel.style.display === 'none') {
            editPanel.style.display = 'block';
        } else {
            editPanel.style.display = 'none';
        }
    }

    document.getElementById('checkPriceBtn').addEventListener('click', function() {
    var startDate = new Date(document.getElementById('startDate').value);
    var endDate = new Date(document.getElementById('endDate').value);
    var diffInDays = Math.ceil(Math.abs(endDate - startDate) / (1000 * 60 * 60 * 24));
    var totalPrice = document.getElementById('totalPrice').getAttribute('data-total-price');
    var value = totalPrice * diffInDays;
    document.getElementById('priceResult').style.display = 'block';
    document.getElementById('priceResult').value = "Cena za wypożyczenie to: " + value.toFixed(2) + " zł.";
    document.getElementById('priceResult2').value = value.toFixed(2);
    document.getElementById('rentMovieBtn').style.display = 'block';
});


    document.getElementById('yes').addEventListener('click', function() {
        document.getElementById('formHide').style.display = 'none';
        document.getElementById('showMe').style.display = 'block';
        document.getElementById('rent').scrollIntoView({ behavior: 'smooth' });
    });

    document.getElementById('rentMovieBtn').addEventListener('click', function() {
        var startDate = new Date(document.getElementById('startDate').value);
        var endDate = new Date(document.getElementById('endDate').value);
        var diffInDays = Math.ceil(Math.abs(endDate - startDate) / (1000 * 60 * 60 * 24));
        var totalPrice = document.getElementById('totalPrice').getAttribute('data-total-price');
        var value = totalPrice * diffInDays;
        document.getElementById('priceResult').style.display = 'block';
        document.getElementById('priceResult').value = "Cena za wypożyczenie to: " + value.toFixed(2) + " zł.";
        document.getElementById('priceResult2').value = value.toFixed(2);
        document.getElementById('rentMovieBtn').style.display = 'block';
        })
</script>
<div id="support-container">
    @include('layouts.support')
</div>
