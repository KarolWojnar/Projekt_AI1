<?php
use App\Http\Controllers\AdminPanel\EditUsersController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\AdminPanel\EditMoviesController;
use App\Http\Controllers\LoansController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\MoviesController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProblemsController;
use App\Http\Controllers\OpinionController;

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
    Route::get('/regulamin', function () {return view('regulamin');})->name('regulamin');
    //edycja danych
    Route::get('users/{id}/edit', [UsersController::class, 'edit'])->name('users.edit');
    Route::put('users/{id}', [UsersController::class, 'update'])->name('users.update');
    Route::post('/opinions', [OpinionController::class, 'store'])->name('opinions.store');
    Route::post('/cancel-loan/{id}', [LoansController::class, 'cancelLoan'])->name('cancelLoan');
    Route::get('/password/change', [ResetPasswordController::class, 'showChangeForm'])->name('password.change');
    Route::post('/password/change', [ResetPasswordController::class, 'change'])->name('password.update');

    //filmy i wypożyczenia, płatność
    Route::put('users/{id}/loan', [UsersController::class, 'update2'])->name('users.update2');
    Route::get('/users/{id}', [UsersController::class, 'show'])->name('users.show');
    Route::get('/movie/{id}', [MoviesController::class, 'show'])->name('movies.show');
    Route::get('/movies', [MoviesController::class, 'index'])->name('movies.index');
    Route::get('/movies/filter', [MoviesController::class, 'filter'])->name('movies.filter');
    Route::get('/movies/search', [MoviesController::class, 'searchMovies'])->name('movies.search');
    Route::get('/cart/{id}', [LoansController::class, 'cartMovie'])->name('addToCart')->middleware('auth');
    Route::get('/cart', [LoansController::class, 'cartShow'])->name('loans.show')->middleware('auth');
    Route::get('/cart/delete/{id}', [LoansController::class, 'deleteFromCart'])->name('deleteFromCart')->middleware('auth');
    Route::post('/process_payment', [PaymentController::class, 'processPayment'])->name('process_payment');
    Route::post('/process_payment_lateFee', [PaymentController::class, 'processPayment_lateFee'])->name('processPayment_lateFee');
    Route::post('/processPayment_late', [PaymentController::class, 'processPayment_late'])->name('processPayment_late');
    Route::post('/payment', [PaymentController::class, 'show'])->name('toPayment');
    Route::get('/payment/succes', [PaymentController::class, 'paymentSuccess'])->name('payment_success');
    Route::get('/payment/error', [PaymentController::class, 'paymentError'])->name('payment_error');
    Route::put('/loans/{id}', [LoansController::class, 'update'])->name('loans.update')->middleware('\App\Http\Middleware\AdminMiddleware::class');

    // ADMIN
    Route::get('/editUsersAdmin',  'App\Http\Controllers\AdminPanel\EditUsersController@index')->middleware('\App\Http\Middleware\AdminMiddleware::class')->name('editUsers');
    Route::get('/editMoviesAdmin',  'App\Http\Controllers\AdminPanel\EditMoviesController@index')->middleware('\App\Http\Middleware\AdminMiddleware::class')->name('editMovies');
    Route::get('/supportPanel',  [ProblemsController::class, 'show'])->middleware('\App\Http\Middleware\AdminMiddleware::class')->name('support');
    Route::post('/supportPanel-send',  [ProblemsController::class, 'create'])->name('addProblem');
    Route::get('/loansAdmin',  [LoansController::class, 'loansShowAll'])->middleware('\App\Http\Middleware\AdminMiddleware::class')->name('loans');
    Route::get('/supportPanel/{id}', [ProblemsController::class, 'updateStatus'])->middleware('\App\Http\Middleware\AdminMiddleware::class')->name('problem.update');
    Route::get('/movies/delete/{id}', [MoviesController::class, 'delete'])->middleware('\App\Http\Middleware\AdminMiddleware::class')->name('movies.delete');
    Route::get('/problems/delete/{id}', [ProblemsController::class, 'delete'])->middleware('\App\Http\Middleware\AdminMiddleware::class')->name('problem.delete');
    Route::get('/users/delete/{id}', [UsersController::class, 'delete'])->middleware('\App\Http\Middleware\AdminMiddleware::class')->name('users.delete');
    Route::put('/movies/{id}', [MoviesController::class, 'update'])->middleware('\App\Http\Middleware\AdminMiddleware::class')->name('movies.update');
    Route::post('/movies', [MoviesController::class, 'store'])->middleware('\App\Http\Middleware\AdminMiddleware::class')->name('movies.store');
    Route::post('/cat', [MoviesController::class, 'catStore'])->middleware('\App\Http\Middleware\AdminMiddleware::class')->name('category.store');
});

