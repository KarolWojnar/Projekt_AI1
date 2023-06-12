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
use App\Http\Controllers\PaymentController;
Auth::routes();
Route::group(['middleware' => ['web']], function () {
    Route::get('/home', function () {return view('home');})->name('home');
    Route::get('/', function () {return view('home');})->name('home');
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
    //filmy i wypożyczenia, płatność
    Route::put('users/{id}/loan', [UsersController::class, 'update2'])->name('users.update2');
    Route::get('/users/{id}', [UsersController::class, 'show'])->name('users.show');
    Route::get('/movie/{id}', [MoviesController::class, 'show'])->name('movies.show');
    Route::get('/movies', [MoviesController::class, 'index'])->name('movies.index');
    Route::get('/movies/filter', [MoviesController::class, 'filter'])->name('movies.filter');
    Route::get('/cart/{id}', [LoansController::class, 'cartMovie'])->name('addToCart')->middleware('auth');
    Route::get('/cart', [LoansController::class, 'cartShow'])->name('loans.show')->middleware('auth');
    Route::get('/cart/delete/{id}', [LoansController::class, 'deleteFromCart'])->name('deleteFromCart')->middleware('auth');
    Route::get('/payment', [PaymentController::class, 'show'])->name('toPayment');
    Route::post('/process_payment', [PaymentController::class, 'processPayment'])->name('process_payment');
    Route::get('/payment/success', function () {return view('payment.success');})->name('payment_success');
    Route::get('/payment/error', function () {return view('payment.error');})->name('payment_error');
    // ADMIN
    Route::get('/editUsersAdmin',  'App\Http\Controllers\AdminPanel\EditUsersController@index')->middleware('\App\Http\Middleware\AdminMiddleware::class')->name('editUsers');
    Route::get('/editMoviesAdmin',  'App\Http\Controllers\AdminPanel\EditMoviesController@index')->middleware('\App\Http\Middleware\AdminMiddleware::class')->name('editMovies');
    Route::get('/movies/delete/{id}', [MoviesController::class, 'delete'])->name('movies.delete');
    Route::get('/users/delete/{id}', [UsersController::class, 'delete'])->name('users.delete');
    Route::put('/movies/{id}', [MoviesController::class, 'update'])->name('movies.update');
    Route::post('/movies', [MoviesController::class, 'store'])->name('movies.store');
});

