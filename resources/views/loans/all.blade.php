@include('layouts.css')
@include('layouts.header')

<div class="container text-white">
    <h1 class="mb-4">Wszystkie zamówienia</h1>

    <div id="orderList" class="collapse show">
        <div class="table-responsive">
            <table class="table text-white">
                <thead>
                    <tr>
                        <th>ID zamówienia</th>
                        <th class="d-none d-lg-table-cell">Data zamówienia</th>
                        <th class="d-none d-lg-table-cell">email klienta</th>
                        <th class="d-none d-lg-table-cell">Filmy</th>
                        <th class="d-none d-lg-table-cell">Status</th>
                        <th>Akcje</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($loans as $loan)
                        <tr>
                            <td>{{ $loan->id }}</td>
                            <td class="d-none d-lg-table-cell">{{ $loan->start_loan }}</td>
                            <td class="d-none d-lg-table-cell">{{ $loan->user->email }}</td>
                            <td class="d-none d-lg-table-cell">
                                <ul>
                                    @foreach ($loan->movies as $movie)
                                        <li>{{ $movie->title }}</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td class="d-none d-lg-table-cell">{{ $loan->status }}</td>
                            <td>
                                <button class="btn custom-btn m-2 w-100" onclick="showForm({{ $loan->id }})">Zmień status</button>
                                <form id="form-{{ $loan->id }}" class="m-2" style="display: none;" action="{{ route('loans.update', $loan->id) }}" method="post">
                                    @csrf
                                    @method('put')
                                    <div class="form-group">
                                        <select name="status" class="form-control">
                                            <option value="Nieopłacone" {{ $loan->status == 'Nieopłacone' ? 'selected' : '' }}>Nieopłacone</option>
                                            <option value="Opłacone" {{ $loan->status == 'Opłacone' ? 'selected' : '' }}>Opłacone</option>
                                            <option value="Wysłane" {{ $loan->status == 'Wysłane' ? 'selected' : '' }}>Wysłane</option>
                                            <option value="Zwrócone" {{ $loan->status == 'Zwrócone' ? 'selected' : '' }}>Zwrócone</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-danger mt-2">Zapisz</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
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
