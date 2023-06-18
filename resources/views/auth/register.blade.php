@include('layouts.app')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-dark3">{{ __('Rejestracja') }}</div>
                <div class="card-body bg-dark text-white">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="row mb-3 ">
                            <label for="first_name" class="col-md-4 col-form-label text-md-end">{{ __('Imie') }}</label>
                            <div class="col-md-6">
                                <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required autocomplete="first_name" autofocus>
                                @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3 ">
                            <label for="last_name" class="col-md-4 col-form-label text-md-end">{{ __('Nazwisko') }}</label>
                            <div class="col-md-6">
                                <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required autocomplete="last_name" autofocus>

                                @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="address" class="col-md-4 col-form-label text-md-end">{{ __('Ulica, numer bloku i mieszkania') }}</label>
                            <div class="col-md-6">
                                <input id="address" type="address" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address') }}" required autocomplete="address">

                                @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="city" class="col-md-4 col-form-label text-md-end">{{ __('Miasto i kod pocztowy') }}</label>

                            <div class="col-md-6">
                                <input id="city" type="city" class="form-control @error('city') is-invalid @enderror" name="city" value="{{ old('city') }}" required autocomplete="city">

                                @error('city')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Hasło') }}</label>
                            <div class="col-md-6">
                                <input type="password" class="form-control @error('new_password') is-invalid @enderror" id="new_password" required minlength="8" name="password">
                                @error('new_password')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Potwierdź hasło') }}</label>

                            <div class="col-md-6">
                                <input type="password" class="form-control @error('confirm_password') is-invalid @enderror" id="confirm_password" name="password_confirmation">
                                @error('confirm_password')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                <p class="text-danger" id="confirmed"></p>
                            </div>
                        </div>
                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4 bg-dark">
                                <button type="submit" class="btn btn-secondary custom-btn">
                                    {{ __('Zarejestruj sie!') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="support-container">
    @include('layouts.support')
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelector('form').addEventListener('submit', function(event) {
            event.preventDefault(); // Zatrzymaj domyślne działanie formularza

            var newPassword = document.getElementById('new_password').value;
            var confirmPassword = document.getElementById('confirm_password').value;

            if (newPassword !== confirmPassword) {
                document.getElementById('confirm_password').classList.add('is-invalid');
                document.getElementById('confirmed').innerHTML = "Hasła się nie zgadzają";
                return;
            }

            // Jeśli walidacja jest poprawna, wyślij żądanie do serwera
            this.removeEventListener('submit', arguments.callee);
            this.submit();
            document.getElementById('confirmed').innerHTML = " ";
        });
    });
</script>

