<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
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
    // LOGIN
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    // SIGN UP
    Route::post('/signup', [UserController::class, 'create']);
});

Route::middleware(['auth'])->group(function () {
    // HOME
    Route::get('/', function () {
        return Inertia::render('MyHome', ['testdata' => 'd']);
    })->name('home');

    // LOGOUT
    Route::get('/logout', [AuthController::class, 'logout']);
});


// CART
Route::get('/cart', [CartController::class, 'getCartProducts']);
Route::post('/cart', [CartController::class, 'upsert']);
Route::delete('/cart/{cart}', [CartController::class, 'delete']);

// SHOP
Route::get('/shop/{shop}', [ShopController::class, 'index'])->name('shop');
Route::post('/shop', [ShopController::class, 'create']);
Route::put('/shop', [ShopController::class, 'update']);
Route::delete('/shop/{shop}', [ShopController::class, 'delete']);

// PRODUCT
Route::get('/shop/{shop}/product/{product}', [ProductController::class, 'index'])->name('product');
Route::get('/product/{product}', [ProductController::class, 'read'])->name('product-read');
Route::post('/product', [ProductController::class, 'create'])->name('product-create');
Route::put('/product', [ProductController::class, 'update'])->name('product-update');
Route::delete('/product/{product}', [ProductController::class, 'delete'])->name('product-delete');
