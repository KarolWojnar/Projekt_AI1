@include('layouts.header')
@include('layouts.css')
<div class="container w-100">
    <ul class="list-group">
        <a href="#" class="btn btn-secondary custom-btn m-3 w-40" onclick="toggleEditPanel(event, {{ $movies }})">Dodaj film</a>
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
                    <button type="submit" class="btn btn-secondary m-2 w-30">Zapisz</button>
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
</script>
