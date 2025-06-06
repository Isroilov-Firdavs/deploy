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
use App\Http\Controllers\QuestionController;


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

        Route::get('/', [CarController::class, 'index'])->name('cars.index');          // List
        Route::get('/create', [CarController::class, 'create'])->name('cars.create');   // Create form
        Route::post('/', [CarController::class, 'store'])->name('cars.store');          // Save new
        Route::get('/{car}', [CarController::class, 'show'])->name('cars.show');        // Show single
        Route::get('/{car}/edit', [CarController::class, 'edit'])->name('cars.edit');   // Edit form
        Route::put('/{car}', [CarController::class, 'update'])->name('cars.update');    // Update existing
        Route::delete('/{car}', [CarController::class, 'destroy'])->name('cars.destroy');// Delete


        Route::get('/report', [ReportController::class, 'index'])->name('report.index');
        Route::get('/football', [FootballController::class, 'index']);
        Route::get('/football/matches', [FootballController::class, 'getMatches'])->name('football.matches');

        Route::resource('questions', QuestionController::class);
        Route::get('/test', [QuestionController::class, 'showTest'])->name('test.show');
        Route::post('/test-submit', [QuestionController::class, 'submitTest'])->name('test.submit');
    });
});




