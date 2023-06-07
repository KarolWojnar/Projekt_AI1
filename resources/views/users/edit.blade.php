
@extends('layouts.header')
@include('layouts.css')
@section('content')
<form action="{{ route('users.update', $user->id) }}" method="POST">
    @csrf
    @method('PUT')
<div class="container w-50">
    <div class="form-control2 bg-dark3 text-white mb-2">
        <label for="first_name">Imie:</label>
        <input type="text" class="form-control w-50 m-auto mb-2" name="first_name" value="{{ $user->first_name }}">
    </div>

    <div class="form-control2 form-group bg-dark3 text-white mb-2">
        <label for="last_name">Nazwisko:</label>
        <input type="text" class="form-control w-50 m-auto mb-2" name="last_name" value="{{ $user->last_name }}">
    </div>

    <div class="form-control2 form-group bg-dark3 text-white mb-2">
        <label for="email">Email:</label>
        <input type="email" class="form-control w-50 m-auto mb-2" name="email" value="{{ $user->email }}">
    </div>

    <div class="form-control2 form-group bg-dark3 text-white mb-2">
        <label for="address">Adres:</label>
        <input type="text" class="form-control w-50 m-auto mb-2" name="address" value="{{ $user->address }}">
    </div>

    <div class="form-control2 form-group bg-dark3 text-white mb-2">
        <label for="city">Miasto:</label>
        <input type="text" class="form-control w-50 m-auto mb-2" name="city" value="{{ $user->city }}">
    </div>
    <button type="submit" class="btn custom-btn ">Zmień swoje dane</button>
</div>
</form>
@endsection
