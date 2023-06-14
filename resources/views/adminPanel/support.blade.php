@include('layouts.header')
@include('layouts.css')
<div class="container w-100">
    <ul class="list-group">
        @foreach($problems as $problem)
            <li class="list-group-item d-flex justify-content-between align-items-center bg-dark text-white">
                <div class="text-white">
                    <span class="fw-bold">{{ $problem->id }}</span>
                    <span class="fw-bold">{{ $problem->email }}</span>
                    <span class="">({{ $problem->typeOf }})</span>
                    <span class="">Opis: {{ $problem->problem }}</span>
                </div>
                <div>
                    <a href="#" class="btn btn-secondary custom-btn" onclick="toggleEditPanel(event, {{ $problem->id }})">Zmień status</a>

                    <a href="{{ route('problem.delete', ['id' => $problem->id]) }}" class="btn btn-danger">Usuń problem</a>
                </div>
            </li>
            <li id="edit-panel-{{ $problem->id }}" class="list-group-item bg-dark text-white edit-panel" style="display: none;">

                <form action="{{ route('problem.update', ['id' => $problem->id]) }}" method="get">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control bg-dark2 text-white" id="status" name="status">
                            @if ($problem->status === 'otwarty')
                                <option value="otwarty" selected>Otwarty</option>
                                <option value="W trakcie rozwiązywania">W trakcie rozwiązywania</option>
                                <option value="Zamknięty">Zamknięty</option>
                            @elseif ($problem->status === 'W trakcie rozwiązywania')
                                <option value="otwarty">Otwarty</option>
                                <option value="W trakcie rozwiązywania" selected>W trakcie rozwiązywania</option>
                                <option value="Zamknięty">Zamknięty</option>
                            @elseif ($problem->status === 'Zamknięty')
                                <option value="otwarty">Otwarty</option>
                                <option value="W trakcie rozwiązywania">W trakcie rozwiązywania</option>
                                <option value="Zamknięty" selected>Zamknięty</option>
                            @else
                                <option value="otwarty">Otwarty</option>
                                <option value="W trakcie rozwiązywania">W trakcie rozwiązywania</option>
                                <option value="Zamknięty">Zamknięty</option>
                            @endif
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

    function toggleAddPanel(event) {
        event.preventDefault();
        var addPanel = document.getElementById('add-panel');
        if (addPanel.style.display === 'none') {
            addPanel.style.display = 'block';
        } else {
            addPanel.style.display = 'none';
        }
    }
    function cancelAddPanel(event) {
        event.preventDefault();
        var addPanel = document.getElementById('add-panel');
        addPanel.style.display = 'none';
    }

</script>
