@include('layouts.header')
@include('layouts.css')
    <div class="container mt-5">
        <div class="card">
            <div class="card-header bg-dark text-white">
                <h1>{{ $user->first_name }} {{ $user->last_name }}</h1>
            </div>
            <div class="card-body bg-dark text-white">
                <p>Email: <strong>{{ $user->email }}</strong></p>
                @if ($user->late_fee > 0)
                    <div class="alert alert-info">
                        <h3 class="text-danger">Masz {{ $user->late_fee }} zł długu</h3>
                        <form method="post" action="{{ route('late_fee') }}">
                            @csrf
                            <input type="hidden" name="late_fee" value="{{ $user->late_fee }}">
                            <button type="submit" class="btn btn-danger mt-3">Opłać karę</button>
                        </form>
                    </div>
                @endif
                <a class="btn custom-btn" href="{{ route('users.edit', ['id' => $user->id]) }}"><b>Edytuj dane</b></a>

                <div class="mt-5">
                    <h3>Twoje wypożyczenia:</h3>
                    <ul class="list-group">
                        @foreach($loans as $loan)
                            <li class="list-group-item rental-item">
                                <div class="movie-title">{{ $loan->movie }}</div>
                                <div class="rental-info">
                                    <span class="info-label">Wypożyczono: </span>
                                    <span class="info-value">{{ $loan->start_loan }}</span>
                                </div>
                                <div class="rental-info">
                                    <span class="info-label">Zwrócono:</span>
                                    <span class="info-value">{{ $loan->returned_at ?? 'Nie zwrócono jeszcze' }}</span>
                                </div>
                                <div class="status-info">
                                    <span class="info-label">Status zamówienia:</span>
                                    <span class="info-value">{{ $loan->status}}</span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div id="support-container">
        @include('layouts.support')
    </div>
