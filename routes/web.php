<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UsersController;


Auth::routes();
//strona główna
Route::get('/home', function () {return view('home');});
Route::get('/', function () {return view('home');});
//logowanie
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/logout', [LoginController::class, 'logout']);
//rejestracja
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
//podstrona użytkownika
Route::get('/users/{id}', [UsersController::class, 'show']);
//regulamin
Route::get('/regulamin', 'App\Http\Controllers\RegulaminController@index')->name('regulamin');
//edycja danych
Route::get('users/{id}/edit', [UsersController::class, 'edit'])->name('users.edit');
Route::put('users/{id}', [UsersController::class, 'update'])->name('users.update');
Route::get('/users/{id}', [UsersController::class, 'show'])->name('users.show');

