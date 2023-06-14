@include('layouts.css')
@include('layouts.header')

    <div class="container text-white">
        <h1>Wszystkie zamówienia</h1>

        <table class="table text-white">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Data zamówienia</th>
                    <th>Klient</th>
                    <th>Filmy</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($loans as $loan)
                    <tr>
                        <td>{{ $loan->id }}</td>
                        <td>{{ $loan->order_date }}</td>
                        <td>{{ $loan->customer }}</td>
                        <td>
                            <ul>
                                @foreach ($loan->movies as $movie)
                                    <li>{{ $movie->title }}</li>
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

<div id="support-container">
    @include('layouts.support')
</div>
