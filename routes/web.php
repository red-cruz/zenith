<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/csrf', function () {
    return ['_token' => csrf_token()];
});

Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return Inertia::render('MyHome', ['testdata' => 'd']);
    })->name('home');
    Route::get('/logout', [AuthController::class, 'logout']);
});

Route::get('/cart', [CartController::class, 'getCartProducts']);
Route::post('/cart', [CartController::class, 'upsert']);
Route::delete('/cart/{cart}', [CartController::class, 'delete']);

Route::get('/shop/{shop}', [ShopController::class, 'index'])->name('shop');
