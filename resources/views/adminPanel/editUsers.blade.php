@include('layouts.header')
@include('layouts.css')
<div class="container w-100">
    <ul class="list-group">
        @foreach($users as $key => $user)
            <li class="list-group-item d-flex justify-content-between align-items-center bg-dark text-white">
                <div class="text-white">
                    <span class="fw-bold">{{ $user->id }}</span>
                    <span class="fw-bold">{{ $user->first_name }}</span>
                    <span class="fw-bold">{{ $user->last_name }}</span>
                    <span class=""> |  Email: {{ $user->email }}</span>
                    <span class=""> |  Adres: {{ $user->city }}, {{ $user->address }}</span>
                </div>
                <div>
                    <a href="#" class="btn btn-secondary custom-btn" onclick="toggleEditPanel(event, {{ $user->id }})">Edytuj</a>

                    <a href="{{ route('users.delete', ['id' => $user->id]) }}" class="btn btn-danger">Usuń</a>
                </div>
            </li>
            <li id="edit-panel-{{ $user->id }}" class="list-group-item bg-dark text-white edit-panel" style="display: none;">

                <form action="{{ route('users.update', ['id' => $user->id]) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="first_name">Imie</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" value="{{ $user->first_name }}">
                    </div>
                    <div class="form-group">
                        <label for="last_name">Nazwisko</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" value="{{ $user->last_name }}">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" class="form-control" id="email" name="email" value="{{ $user->email }}">
                    </div>
                    <div class="form-group">
                        <label for="address">Adres</label>
                        <input type="text" class="form-control" id="address" name="address" value="{{ $user->address }}">
                    </div>
                    <div class="form-group">
                        <label for="city">Miasto</label>
                        <input type="text" class="form-control" id="city" name="city" value="{{ $user->city }}">
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
