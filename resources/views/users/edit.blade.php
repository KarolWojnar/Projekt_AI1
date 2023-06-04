
@extends('layouts.app')

@section('content')
<form action="{{ route('users.update', $user->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="form-control bg-dark3">
        <label for="first_name">Pierwsze Imie:</label>
        <input type="text" class="form-control w-50" name="first_name" value="{{ $user->first_name }}">
    </div>

    <div class="form-group">
        <label for="last_name">Last Name:</label>
        <input type="text" class="form-control" name="last_name" value="{{ $user->last_name }}">
    </div>

    <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" class="form-control" name="email" value="{{ $user->email }}">
    </div>

    <div class="form-group">
        <label for="address">Address:</label>
        <input type="text" class="form-control" name="address" value="{{ $user->address }}">
    </div>

    <div class="form-group">
        <label for="city">City:</label>
        <input type="text" class="form-control" name="city" value="{{ $user->city }}">
    </div>

    <button type="submit" class="btn btn-primary">Save Changes</button>
</form>
@endsection
