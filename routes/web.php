<?php
use App\Http\Controllers\AdminPanel\EditUsersController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AdminPanel\EditMoviesController;
use App\Http\Controllers\LoansController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\MoviesController;
use App\Http\Controllers\RegulaminController;
Auth::routes();
Route::group(['middleware' => ['web']], function () {
Route::get('/home', function () {return view('home');});
Route::get('/', function () {return view('home');});
//logowanie
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/logout', [LoginController::class, 'logout']);
//rejestracja
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
//regulamin
Route::get('/regulamin', [RegulaminController::class, 'index'])->name('regulamin');
//edycja danych
Route::get('users/{id}/edit', [UsersController::class, 'edit'])->name('users.edit');
Route::put('users/{id}', [UsersController::class, 'update'])->name('users.update');
Route::put('users/{id}/loan', [UsersController::class, 'update2'])->name('users.update2');
Route::get('/users/{id}', [UsersController::class, 'show'])->name('users.show');
Route::get('/movie/{id}', [MoviesController::class, 'show'])->name('movies.show');
Route::get('/movies', [MoviesController::class, 'index'])->name('movies.index');
Route::get('/movies/filter', [MoviesController::class, 'filter'])->name('movies.filter');
Route::get('/movie/{id}/loan', [LoansController::class, 'rentMovie'])->name('loans.show')->middleware('auth');
Route::post('/calculate-price', [LoansController::class, 'calculatePrice'])->name('calculatePrice');
// ADMIN
Route::get('/editUsersAdmin',  'App\Http\Controllers\AdminPanel\EditUsersController@index')->middleware('\App\Http\Middleware\AdminMiddleware::class')->name('editUsers');
Route::get('/editMoviesAdmin',  'App\Http\Controllers\AdminPanel\EditMoviesController@index')->middleware('\App\Http\Middleware\AdminMiddleware::class')->name('editMovies');
Route::get('/movies/delete/{id}', [MoviesController::class, 'delete'])->name('movies.delete');
Route::get('/users/delete/{id}', [UsersController::class, 'delete'])->name('users.delete');
Route::put('/movies/{id}', [MoviesController::class, 'update'])->name('movies.update');
Route::post('/movies', [MoviesController::class, 'store'])->name('movies.store');
});
