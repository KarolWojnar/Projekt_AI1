@extends('layouts.app')

@section('content')
    <div class="text-white">
    <h1>{{ $user->first_name }} {{ $user->last_name }}</h1>
    <p>Twoje ID: {{ $user->id }}</p>
    <p>Email: {{ $user->email }}</p>
    <a class="btn btn-dark" href="{{ route('users.edit', ['id' => $user->id]) }}"><b>Edytuj dane</b></a>
    </div>
@endsection
