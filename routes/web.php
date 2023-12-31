<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ParentCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShopAddressController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserAddressController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VariationController;
use App\Http\Controllers\VariationOptionController;
use App\Models\Product;
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
    Route::post('/register', [UserController::class, 'create']);
});

// HOME
Route::get('/', function () {
    $products = Product::all();
    foreach ($products as $product) {
        $product->ratings;
        $product->price_percentage_diff;
    }
    // dd($products);
    return Inertia::render('MyHome', ['products' => $products]);
})->name('home');

Route::middleware(['auth'])->group(function () {

    // admin
    Route::middleware(['admin'])->group(function () {

    });


    // LOGOUT
    Route::get('/logout', [AuthController::class, 'logout']);
});

// CATEGORY
// Route::get('/categories', [CategoryController::class, 'showAll']);
Route::get('/category/{category}', [CategoryController::class, 'show']);
Route::post('/category', [CategoryController::class, 'create']);
Route::put('/category', [CategoryController::class, 'update']);
Route::delete('/category/{category}', [CategoryController::class, 'delete']);

// PARENT CATEGORY
Route::get('/categories', [ParentCategoryController::class, 'showAll']);
Route::get('/category/parent/{parentCategory}', [ParentCategoryController::class, 'show']);
Route::post('/category/parent', [ParentCategoryController::class, 'create']);
Route::put('/category/parent', [ParentCategoryController::class, 'update']);
Route::delete('/category/parent/{parentCategory}', [ParentCategoryController::class, 'delete']);

// USER
Route::get('/user/{user}', [UserController::class, 'read']);
Route::put('/user', [UserController::class, 'update']);
Route::delete('/user/{user}', [UserController::class, 'delete']);

// USER ADDRESS
Route::post('/userAddress', [UserAddressController::class, 'create']);
Route::get('/userAddress/{userAddress}', [UserAddressController::class, 'read']);
Route::put('/userAddress', [UserAddressController::class, 'update']);
Route::delete('/userAddress/{userAddress}', [UserAddressController::class, 'delete']);

// CART
Route::get('/cart', [CartController::class, 'getCartProducts']);
Route::post('/cart', [CartController::class, 'upsert']);
Route::delete('/cart/{cart}', [CartController::class, 'delete']);

// SHOP
Route::get('/shop/{shop}', [ShopController::class, 'index'])->name('shop');
Route::post('/shop', [ShopController::class, 'create']);
Route::put('/shop', [ShopController::class, 'update']);
Route::delete('/shop/{shop}', [ShopController::class, 'delete']);
Route::patch('/shop/{shop}/restore', [ShopController::class, 'restore'])->name('shop-restore');
Route::delete('/shop/{shop}/delete-permanent', [ShopController::class, 'forceDelete'])->name('shop-force-delete');

// PRODUCT
Route::get('/shop/{shop}/product/{product}', [ProductController::class, 'index'])->name('product');
Route::get('/product/{product}', [ProductController::class, 'read'])->name('product-read');
Route::post('/product', [ProductController::class, 'create'])->name('product-create');
Route::put('/product', [ProductController::class, 'update'])->name('product-update');
Route::delete('/product/{product}', [ProductController::class, 'delete'])->name('product-delete');

// VARIATIONS
Route::get('/variations', [VariationController::class, 'showAll']);
Route::get('/variation/{variation}', [VariationController::class, 'show']);
Route::post('/variation', [VariationController::class, 'create']);
Route::put('/variation', [VariationController::class, 'update']);
Route::delete('/variation/{variation}', [VariationController::class, 'delete']);

// VARIATION OPTIONS
Route::get('/variation/{variation}/option/{variationOption}', [VariationOptionController::class, 'show']);
Route::post('/variation/option', [VariationController::class, 'create']);
Route::put('/variation/option', [VariationController::class, 'update']);
Route::delete('/variation/option/{variationOption}', [VariationController::class, 'delete']);
