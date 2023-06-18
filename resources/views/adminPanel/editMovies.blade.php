@include('layouts.header')
@include('layouts.css')
<div class="container w-100">
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
    <div class="d-flex justify-content-between mb-3">
        <a href="#" class="btn btn-secondary custom-btn" onclick="toggleAddPanel(event, 'movie')">Dodaj film</a>
        <a href="#" class="btn btn-secondary custom-btn" onclick="toggleAddPanel(event, 'category')">Dodaj kategorię</a>
    </div>
    <li id="add-panel-movie" class="list-group-item bg-dark text-white edit-panel" style="display: none;">
        <form action="{{ route('movies.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="title">Tytuł</label>
                <input type="text" class="form-control" id="title" name="title" required value="">
            </div>
            <div class="form-group">
                <label for="genre">Gatunek</label>
                <select id="category_id" name="category_id" class="form-control" required>
                    <option value="">Wybierz</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->genre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="description">Opis</label>
                <input type="text" class="form-control" id="description" name="description" required value="">
            </div>
            <div class="form-group">
                <label for="director">Reżyser</label>
                <input type="text" class="form-control" id="director" name="director" required value="">
            </div>
            <div class="form-group">
                <label for="release">Rok premiery</label>
                <input type="number" class="form-control" id="release" name="release" required value="">
            </div>
            <div class="form-group">
                <label for="longTime">Czas trwania w minutach</label>
                <input type="number" class="form-control" id="longTime" name="longTime" required value="">
            </div>
            <div class="form-group">
                <label for="rate">Ocena</label>
                <input type="number" step="any" class="form-control" id="rate" name="rate" required value="">
            </div>
            <div class="form-group">
                <label for="pricePerDay">Cena za dzień</label>
                <input type="number" class="form-control" step="any" id="pricePerDay" name="pricePerDay" required value="">
            </div>
            <div class="form-group">
                <label for="image">Dodaj zdjęcie</label>
                <input type="file" class="form-control" id="img_path" name="img_path">
            </div>
            <div class="form-group">
                <label for="available">Dostępność</label>
                <select id="available" name="available" class="form-control">
                    <option value="dostępny">dostępny</option>
                    <option value="niedostępny">niedostępny</option>
                </select>
            </div>
            <button type="submit" class="btn btn-secondary custom-btn m-2 w-30">Dodaj</button>
        </form>
        <li id="add-panel-category" class="list-group-item bg-dark text-white edit-panel" style="display: none;">
            <form action="{{route('category.store')}}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="genre">Nazwa nowego gatunku</label>
                    <input type="text" class="form-control" id="genre" required name="genre" value="">
                </div>
                <button type="submit" class="btn btn-secondary custom-btn m-2 w-30">Dodaj</button>
            </form>
        </li>
    </li>
    <ul class="list-group">
        @foreach($movies as $movie)
            <li class="list-group-item d-flex justify-content-between align-items-center bg-dark text-white">
                <div class="text-white">
                    <span class="fw-bold">{{ $movie->id }}</span>
                    <span class="fw-bold">{{ $movie->title }}</span>
                    <span class="">Premiera: {{ $movie->release }}</span>
                    <span class="">Dostępność: {{ $movie->available }}</span>
                </div>
                <div>
                    <a href="#" style="" class="btn btn-secondary custom-btn @if ($movie->available == 'niedostępny') disabled @endif" onclick="toggleEditPanel(event, {{ $movie->id }})">Edytuj</a>

                    <a href="{{ route('movies.delete', ['id' => $movie->id]) }}" class="btn btn-danger @if ($movie->available == 'niedostępny') disabled @endif">Usuń</a>
                </div>
            </li>
            <li id="edit-panel-{{ $movie->id }}" class="list-group-item bg-dark text-white edit-panel" style="display: none;">

                <form action="{{ route('movies.update', ['id' => $movie->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="title">Tytuł</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ $movie->title }}">
                    </div>
                    <div class="form-group">
                        <label for="genre">Gatunek</label>
                        <select id="category_id" name="category_id" class="form-control">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @if ($category->id == $movie->category_id) selected @endif>{{ $category->genre }}</option>
                            @endforeach
                        </select>
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
                        <input type="number" class="form-control" id="release" name="release" min="0" value="{{ $movie->release }}">
                    </div>
                    <div class="form-group">
                        <label for="longTime">Czas trwania w minutach</label>
                        <input type="number" class="form-control" id="longTime" name="longTime" min="0" value="{{ $movie->longTime }}">
                    </div>
                    <div class="form-group">
                        <label for="rate">Ocena</label>
                        <input type="number" step="any" class="form-control" id="rate" name="rate" min="0" value="{{ $movie->rate }}">
                    </div>
                    <div class="form-group">
                        <label for="pricePerDay">Cena za dzień</label>
                        <input type="number" step="any" class="form-control" id="pricePerDay" name="pricePerDay" min="0" value="{{ $movie->pricePerDay }}">
                    </div>
                    <div class="form-group">
                        <label for="image">Zmień zdjęcie</label>
                        <input type="file" class="form-control" id="img_path" name="img_path">
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
<div id="support-container">
    @include('layouts.support')
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

    function toggleAddPanel(event, panelId) {
        event.preventDefault();
        var addPanel = document.getElementById('add-panel-' + panelId);
        if (addPanel.style.display === 'none') {
            addPanel.style.display = 'block';
        } else {
            addPanel.style.display = 'none';
        }
    }

    function cancelAddPanel(event) {
        event.preventDefault();
        var addPanels = document.getElementsByClassName('edit-panel');
        for (var i = 0; i < addPanels.length; i++) {
            addPanels[i].style.display = 'none';
        }
    }
</script>
