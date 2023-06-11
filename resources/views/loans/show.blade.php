@include('layouts.css')
@include('layouts.header')

<div class="container">
    <div class="row">
        <div class="col-lg-6">
            <div class="text-white text-center">
                <form method="get" action="{{route('regulamin')}}">
                    @csrf
                    <div>
                        @php
                        $minDate = now()->addDay(1)->toDateString();
                        $maxDate = now()->addDays(14)->toDateString();
                        @endphp
                        <h3>Witaj {{ $user->first_name }}! Wybrałeś film "{{ $movie->title }}"</h3>
                        <div class="w-50 m-auto">
                            <img src="{{ asset($movie->img_path) }}" class="img-fluid w-50 m-auto" alt="{{ $movie->title }}">
                        </div>
                        <h5>Cena tego filmu za dzień to: {{ $movie->pricePerDay }} zł</h5>
                    </div>
                    <div class="form-group w-50 mx-auto">
                        <label for="startDate">Data początku wypożyczenia:</label>
                        <input type="date" id="startDate" name="startDate" value="" class="form-control" min="{{ $minDate }}" max="{{ date('Y-m-d', strtotime('+7 days')) }}" required>
                    </div>

                    <div id="endDateWrapper" class="form-group w-50 mx-auto" style="display: none;">
                        <label for="endDate">Data końca wypożyczenia:</label>
                        <input type="date" id="endDate" name="endDate" value="" class="form-control" min="{{ $minDate }}" required>
                    </div>

                    <button type="submit" id="rentMovieBtn" class="btn custom-btn mt-3 mx-auto" style="display: none;" disabled>Wypożycz film"{{ $movie->title }}"</button>
                    <button type="button" id="checkPriceBtn" class="btn custom-btn mt-3 mx-auto" disabled style="pointer-events: none; cursor: default;">Sprawdź cenę</button>
                </form>

                <div class="mt-3">
                    <h4 id="priceResult"></h4>
                </div>
            </div>
        </div>

        <div class="col-lg-6 text-white text-center">
            <h2 class="text-dark bg-danger">ZANIM WYPOŻYCZYSZ</h2>
            <h6>Czy Twoje dane adresowe są poprawnie podane na profilu?</h6>
            <div class="text-white M-AUTO">
                <button href="" class="btn custom-btn mt-3 col-lg-4" onclick="SetEnabelLoan(event, {{ $user->id }})">TAK</button>
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
</div>

<script>

    function SetEnableLoan(event, userId) {
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


    document.getElementById('checkPriceBtn').addEventListener('click', function() {
        var startDate = document.getElementById('startDate').value;
        var endDate = document.getElementById('endDate').value;

        if (startDate && endDate) {
            var data = {
                "_token": "{{ csrf_token() }}",
                "movieId": "{{ $movie->id }}",
                "startDate": startDate,
                "endDate": endDate
            };

            fetch("{{ route('calculatePrice') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('priceResult').innerText = 'Cena: ' + data.price + ' zł';
                    document.getElementById('rentMovieBtn').style.display = 'block';
                } else {
                    document.getElementById('priceResult').innerText = 'Wystąpił błąd. Spróbuj ponownie.';
                    document.getElementById('rentMovieBtn').style.display = 'none';
                }
            })
            .catch(error => {
                document.getElementById('priceResult').innerText = 'Wystąpił błąd. Spróbuj ponownie.';
                document.getElementById('rentMovieBtn').style.display = 'none';
            });
        }
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
</script>
