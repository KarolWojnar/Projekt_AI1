@extends('layouts.header')
@include('layouts.css')
@section('content')
<form action="{{ route('users.update', $user->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="container w-50">
        <div class="form-control2 bg-dark3 text-white mb-2">
            <label for="first_name">Imie:</label>
            <input type="text" class="form-control w-80 m-auto mb-2" name="first_name" id="first_name" required value="{{ $user->first_name }}">
        </div>

        <div class="form-control2 form-group bg-dark3 text-white mb-2">
            <label for="last_name">Nazwisko:</label>
            <input type="text" class="form-control w-80 m-auto mb-2" name="last_name" id="last_name" required value="{{ $user->last_name }}">
        </div>

        <div class="form-control2 form-group bg-dark3 text-white mb-2">
            <label for="email">Email:</label>
            <input type="email" class="form-control w-80 m-auto mb-2" name="email" id="email" required value="{{ $user->email }}">
        </div>

        <div class="form-control2 form-group bg-dark3 text-white mb-2">
            <label for="address">Adres:</label>
            <input type="text" class="form-control w-80 m-auto mb-2" name="address" id="address" required value="{{ $user->address }}">
        </div>

        <div class="form-control2 form-group bg-dark3 text-white mb-2">
            <label for="city">Miasto:</label>
            <input type="text" class="form-control w-80 m-auto mb-2" name="city" id="city" required value="{{ $user->city }}">
        </div>
        <button type="submit" class="btn custom-btn ">Zmień swoje dane</button>
        @if ($errors->any())
        <div class="alert alert-danger mt-3">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @elseif (session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
        <script>
            setTimeout(function() {
                window.location.href = "/users/{{ Auth::id() }}";
            }, 2500);
        </script>
        @endif
    </div>
</form>

@endsection
<div id="support-container">
    @include('layouts.support')
</div>
