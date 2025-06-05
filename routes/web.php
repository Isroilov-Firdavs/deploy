<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MokaroUsersController;
use App\Http\Controllers\TelegramBotController;
use App\Http\Controllers\MatchController;
use App\Http\Controllers\ScraperController;

use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Product\PurchaseController;
use App\Http\Controllers\Product\SaleController;
use App\Http\Controllers\Product\ReportController;
use App\Http\Controllers\FootballController;
use App\Http\Controllers\CarController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::middleware(['web'])->group(function () {
    Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::middleware(['check.admin'])->group(function () {
        Route::get('/', fn() => view('welcome'))->name('home');
        Route::post('/telegram/webhook', [TelegramBotController::class, 'handle']);
        Route::get('/users/fetch', [MatchController::class, 'fetch'])->name('users.fetch');
        Route::delete('/users/{id}', [MatchController::class, 'destroy'])->name('users.destroy');
        Route::put('/users/{id}', [MatchController::class, 'update'])->name('users.update');
        Route::get('/users/api', [MokaroUsersController::class, 'api'])->name('users.api');
        Route::get('/users/matches', [MatchController::class, 'todayMatches'])->name('users.matches');
        Route::resource('users', MokaroUsersController::class);
        Route::get('/match', [ScraperController::class, 'index']);
        // Route::get('/', function () {
        //     return redirect('/products');
        // });

        Route::resource('products', ProductController::class);
        Route::resource('purchases', PurchaseController::class);
        Route::resource('sales', SaleController::class);
        Route::resource('cars', CarController::class);

        Route::get('/report', [ReportController::class, 'index'])->name('report.index');
        Route::get('/football', [FootballController::class, 'index']);
        Route::get('/football/matches', [FootballController::class, 'getMatches'])->name('football.matches');
    });
});




