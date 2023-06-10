@include('layouts.css')
@include('layouts.header')
<div class="container text-white">
    <form method="POST" action="{{ route('calculatePrice') }}">
        @csrf
        <div>
            @php
            $minDate = now()->addDay(1)->toDateString();
            $maxDate = now()->addDays(14)->toDateString();
            @endphp
            <h3>Witaj {{ $user->first_name }}! Wybrałeś film "{{ $movie->title }}"</h3>
            <h5>Cena tego filmu za dzień to: {{ $movie->pricePerDay }} zł</h5>
        </div>
        <div class="form-group w-50">
            <label for="startDate">Data początku wypożyczenia:</label>
            <input type="date" id="startDate" name="startDate" value="" class="form-control" min="{{ $minDate }}" max="{{ date('Y-m-d', strtotime('+7 days')) }}" required>
        </div>

        <div id="endDateWrapper" class="form-group w-50" style="display: none;">
            <label for="endDate">Data końca wypożyczenia:</label>
            <input type="date" id="endDate" name="endDate" value="" class="form-control" min="{{ $minDate }}" required>
        </div>

        <button type="submit" class="btn custom-btn mt-3">Wypożycz film "{{ $movie->title }}"</button>
        <button type="button" id="checkPriceBtn" class="btn custom-btn mt-3" disabled style="pointer-events: none; cursor: default;">Sprawdź cenę</button>
    </form>

    <div class="mt-3">
        <h4 id="priceResult"></h4>
    </div>
</div>

<script>
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
        document.getElementById('checkPriceBtn').removeAttribute('disabled');
        document.getElementById('checkPriceBtn').style.pointerEvents = 'auto';
        document.getElementById('checkPriceBtn').style.cursor = 'pointer';
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
                } else {
                    document.getElementById('priceResult').innerText = 'Wystąpił błąd. Spróbuj ponownie.';
                }
            })
            .catch(error => {
                document.getElementById('priceResult').innerText = 'Wystąpił błąd. Spróbuj ponownie.';
            });
        }
    });
</script>
