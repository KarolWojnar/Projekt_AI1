@include('layouts.header')
@include('layouts.css')
<style>
    .list-group-item {
        flex-wrap: wrap;
    }

    @media (max-width: 576px) {
        .list-group-item {
            flex-direction: column;
            align-items: flex-start;
        }

        .list-group-item .text-white {
            margin-bottom: 1rem;
        }

        .list-group-item .wrap {
            margin-top: 1rem;
        }
    }
</style>

<div class="container">
    @if ($errors->any())
        <div class="alert alert-danger mt-3">
            @foreach ($errors->all() as $error)
                <strong>{{ $error }}</strong>
            @endforeach
        </div>
    @elseif (session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif
    <ul class="list-group">
        @foreach($problems as $problem)
            <li class="list-group-item d-flex justify-content-between align-items-center bg-dark text-white">
                <div class="text-white">
                    <span class="fw-bold">{{ $problem->id }}</span>
                    <span class="fw-bold">{{ $problem->email }}</span>
                    <span class="">({{ $problem->typeOf }})</span><br>
                    <span class="m-4" style="display: block;max-width: 40rem;word-wrap: break-word;"><strong>Opis:</strong>  {{ $problem->problem }}</span>
                </div>
                <div class="d-flex wrap">
                    <a href="#" class="btn btn-secondary custom-btn m-2" onclick="toggleEditPanel(event, {{ $problem->id }})">Zmień status</a>
                    <a href="{{ route('problem.delete', ['id' => $problem->id]) }}" class="btn btn-danger m-2">Usuń problem</a>
                </div>
            </li>
            <li id="edit-panel-{{ $problem->id }}" class="list-group-item bg-dark text-white edit-panel" style="display: none;">
                <form action="{{ route('problem.update', ['id' => $problem->id]) }}" method="get">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control bg-dark2 text-white" id="status" name="status">
                            <option value="otwarty" {{ $problem->status === 'otwarty' ? 'selected' : '' }}>Otwarty</option>
                            <option value="W trakcie rozwiązywania" {{ $problem->status === 'W trakcie rozwiązywania' ? 'selected' : '' }}>W trakcie rozwiązywania</option>
                            <option value="Zamknięty" {{ $problem->status === 'Zamknięty' ? 'selected' : '' }}>Zamknięty</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-secondary custom-btn m-2 w-30">Zapisz</button>
                    <button type="button" class="btn btn-secondary custom-btn m-2 w-30" onclick="cancelEditPanel(event, {{ $problem->id }})">Anuluj</button>
                </form>
            </li>
        @endforeach
    </ul>
</div>
<div id="support-container">
    @include('layouts.support')
</div>
<script>
    function toggleEditPanel(event, problemId) {
        event.preventDefault();
        var editPanel = document.getElementById('edit-panel-' + problemId);
        if (editPanel.style.display === 'none') {
            editPanel.style.display = 'block';
        } else {
            editPanel.style.display = 'none';
        }
    }

    function cancelEditPanel(event, problemId) {
        event.preventDefault();
        var editPanel = document.getElementById('edit-panel-' + problemId);
        editPanel.style.display = 'none';
    }
</script>
