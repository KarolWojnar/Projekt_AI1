<?php

<<<<<<< HEAD
use App\Http\Controllers\AdminPanel\EditUsersController;
=======
>>>>>>> cce75a64d2c95dceede8bcf1e3a98cb78e849b6a
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
<<<<<<< HEAD
use App\Http\Controllers\AdminPanel\EditMoviesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\MoviesController;
=======
use App\Http\Controllers\UsersController;
>>>>>>> cce75a64d2c95dceede8bcf1e3a98cb78e849b6a


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
<<<<<<< HEAD
=======
//podstrona użytkownika
Route::get('/users/{id}', [UsersController::class, 'show']);
Route::get('/users/{id}', 'UsersController@show')->name('users.show');
>>>>>>> cce75a64d2c95dceede8bcf1e3a98cb78e849b6a
//regulamin
Route::get('/regulamin', 'App\Http\Controllers\RegulaminController@index')->name('regulamin');
//edycja danych
Route::get('users/{id}/edit', [UsersController::class, 'edit'])->name('users.edit');
Route::put('users/{id}', [UsersController::class, 'update'])->name('users.update');
Route::get('/users/{id}', [UsersController::class, 'show'])->name('users.show');
<<<<<<< HEAD
//ADMIN
Route::get('/editUsersAdmin',  'App\Http\Controllers\AdminPanel\EditUsersController@index')->middleware('\App\Http\Middleware\AdminMiddleware::class')->name('editUsers');
Route::get('/editMoviesAdmin',  'App\Http\Controllers\AdminPanel\EditMoviesController@index')->middleware('\App\Http\Middleware\AdminMiddleware::class')->name('editMovies');
Route::get('/movies/delete/{id}', [MoviesController::class, 'delete'])->name('movies.delete');

=======
>>>>>>> cce75a64d2c95dceede8bcf1e3a98cb78e849b6a

