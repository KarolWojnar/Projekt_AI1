@include('layouts.header')
@include('layouts.css')
<div class="container w-100">
    <a href="#" class="btn btn-secondary custom-btn mb-3" onclick="toggleAddPanel(event)">Dodaj film</a>
    <li id="add-panel" class="list-group-item bg-dark text-white edit-panel" style="display: none;">
        <form action="{{ route('movies.store') }}" method="POST">
            @csrf
            <div class="form-group">
                    <label for="title">Tytuł</label>
                    <input type="text" class="form-control" id="title" name="title" value="">
                </div>
                <div class="form-group">
                    <label for="genre">Gatunek</label>
                    <input type="text" class="form-control" id="genre" name="genre" value="">
                </div>
                <div class="form-group">
                    <label for="description">Opis</label>
                    <input type="text" class="form-control" id="description" name="description" value="">
                </div>
                <div class="form-group">
                    <label for="director">Reżyser</label>
                    <input type="text" class="form-control" id="director" name="director" value="">
                </div>
                <div class="form-group">
                    <label for="release">Rok premiery</label>
                    <input type="text" class="form-control" id="release" name="release" value="">
                </div>
                <div class="form-group">
                    <label for="longTime">Czas trwania w minutach</label>
                    <input type="text" class="form-control" id="longTime" name="longTime" value="">
                </div>
                <div class="form-group">
                    <label for="rate">Ocena</label>
                    <input type="text" class="form-control" id="rate" name="rate" value="">
                </div>
                <div class="form-group">
                    <label for="pricePerDay">Cena za dzień</label>
                    <input type="text" class="form-control" id="pricePerDay" name="pricePerDay" value="">
                </div>
                <div class="form-group">
                    <label for="img_path">Dodaj ścieżkę do zdjęcia</label>
                    <input type="text" class="form-control" id="img_path" name="img_path" value="img/example.jpg">
                </div>
                <div class="form-group">
                    <label for="available">Dostępność</label>
                    <select id="available" name="available" class="form-control">
                            <option value="dostępny">dostępny</option>
                            <option value="niedostępny">niedostępny</option>
                    </select>
                </div>

            <button type="submit" class="btn btn-secondary custom-btn m-2 w-30">Dodaj</button>
            <button type="button" class="btn btn-secondary custom-btn m-2 w-30" onclick="cancelAddPanel(event)">Anuluj</button>
        </form>
    </li>
    <ul class="list-group">
        @foreach($movies as $movie)
            <li class="list-group-item d-flex justify-content-between align-items-center bg-dark text-white">
                <div class="text-white">
                    <span class="fw-bold">{{ $movie->id }}</span>
                    <span class="fw-bold">{{ $movie->title }}</span>
                    <span class="">({{ $movie->genre }})</span>
                    <span class="">Premiera: {{ $movie->release }}</span>
                    <span class="">Dostępność: {{ $movie->available }}</span>
                </div>
                <div>
                    <a href="#" class="btn btn-secondary custom-btn" onclick="toggleEditPanel(event, {{ $movie->id }})">Edytuj</a>

                    <a href="{{ route('movies.delete', ['id' => $movie->id]) }}" class="btn btn-danger">Usuń</a>
                </div>
            </li>
            <li id="edit-panel-{{ $movie->id }}" class="list-group-item bg-dark text-white edit-panel" style="display: none;">

                <form action="{{ route('movies.update', ['id' => $movie->id]) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="title">Tytuł</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ $movie->title }}">
                    </div>
                    <div class="form-group">
                        <label for="genre">Gatunek</label>
                        <input type="text" class="form-control" id="genre" name="genre" value="{{ $movie->genre }}">
                    </div>
                    <div class="form-group">
                        <label for="description">Opis</label>
                        <input type="text" class="form-control" id="description" name="description" value="{{ $movie->description }}">
                    </div>
                    <div class="form-group">
                        <label for="director">Reżyser</label>
                        <input type="text" class="form-control" id="director" name="director" value="{{ $movie->director }}">
                    </div>
                    <div class="form-group">
                        <label for="release">Rok premiery</label>
                        <input type="text" class="form-control" id="release" name="release" value="{{ $movie->release }}">
                    </div>
                    <div class="form-group">
                        <label for="longTime">Czas trwania w minutach</label>
                        <input type="text" class="form-control" id="longTime" name="longTime" value="{{ $movie->longTime }}">
                    </div>
                    <div class="form-group">
                        <label for="rate">Ocena</label>
                        <input type="text" class="form-control" id="rate" name="rate" value="{{ $movie->rate }}">
                    </div>
                    <div class="form-group">
                        <label for="pricePerDay">Cena za dzień</label>
                        <input type="text" class="form-control" id="pricePerDay" name="pricePerDay" value="{{ $movie->pricePerDay }}">
                    </div>
                    <div class="form-group">
                        <label for="img_path">Zmień zdjęcie</label>
                        <input type="text" class="form-control" id="img_path" name="img_path" value="{{ $movie->img_path }}">
                    </div>
                    <div class="form-group">
                        <label for="available">Dostępność</label>
                        <select id="available" name="available" class="form-control">
                            <option value="{{ $movie->available }}" selected>{{ $movie->available }}</option>
                            @if ($movie->available == "dostępny")
                                <option value="niedostępny">niedostępny</option>
                            @else
                                <option value="dostępny">dostępny</option>
                            @endif
                        </select>
                    </div>
                    <button type="submit" class="btn btn-secondary custom-btn m-2 w-30">Zapisz</button>
                    <button type="button" class="btn btn-secondary custom-btn m-2 w-30" onclick="cancelEditPanel(event, {{ $movie->id }})">Anuluj</button>
                </form>
            </li>
        @endforeach
    </ul>
</div>
<script>
    function toggleEditPanel(event, movieId) {
        event.preventDefault();
        var editPanel = document.getElementById('edit-panel-' + movieId);
        if (editPanel.style.display === 'none') {
            editPanel.style.display = 'block';
        } else {
            editPanel.style.display = 'none';
        }
    }
    function cancelEditPanel(event, movieId) {
        event.preventDefault();
        var editPanel = document.getElementById('edit-panel-' + movieId);
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
