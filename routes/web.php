<?php

use App\Http\Controllers\CartController;
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

Route::get('/', function () {
    return Inertia::render('MyHome', ['testdata' => 'd']);
});

Route::get('/cart', [CartController::class, 'getCartProducts']);
Route::post('/cart', [CartController::class, 'upsert']);
Route::delete('/cart/{cart}', [CartController::class, 'delete']);
