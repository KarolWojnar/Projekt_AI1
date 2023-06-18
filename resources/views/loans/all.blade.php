<!-- Widok: resources/views/loans/index.blade.php -->

@include('layouts.css')
@include('layouts.header')

<div class="container text-white">
    <h1>Wszystkie zamówienia</h1>

    <table class="table text-white">
        <thead>
            <tr>
                <th>ID zamówienia</th>
                <th>Data zamówienia</th>
                <th>emial klienta</th>
                <th>Filmy</th>
                <th>Status</th>
                <th>Akcje</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($loans as $loan)
                <tr>
                    <td>{{ $loan->id }}</td>
                    <td>{{ $loan->start_loan }}</td>
                    <td>{{ $loan->user->email }}</td>
                    <td>
                        <ul>
                            @foreach ($loan->movies as $movie)
                                <li>{{ $movie->title }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>{{ $loan->status }}</td>
                    <td>
                        <button class="btn custom-btn m-2 w-100" onclick="showForm({{ $loan->id }})">Zmień status</button>
                        <form id="form-{{ $loan->id }}" class="m-2" style="display: none;" action="{{ route('loans.update', $loan->id) }}" method="post">
                            @csrf
                            @method('put')
                            <select name="status" class="form-control">
                                <option value="Nieopłacone" {{ $loan->status == 'Nieopłacone' ? 'selected' : '' }}>Nieopłacone</option>
                                <option value="Opłacone" {{ $loan->status == 'Opłacone' ? 'selected' : '' }}>Opłacone</option>
                                <option value="Wysłane" {{ $loan->status == 'Wysłane' ? 'selected' : '' }}>Wysłane</option>
                                <option value="Zwrócone" {{ $loan->status == 'Zwrócone' ? 'selected' : '' }}>Zwrócone</option>
                            </select>
                            <button type="submit" class="btn btn-danger mt-2">Zapisz</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    function showForm(id) {
        var form = document.getElementById('form-' + id);
        if (form.style.display === 'none') {
            form.style.display = 'block';
        } else {
            form.style.display = 'none';
        }
    }
</script>

<div id="support-container">
    @include('layouts.support')
</div>
