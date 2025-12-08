<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\MainPageController;

Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::delete('/logout', [AuthController::class, 'logout'])->name('logout');

Route::prefix('/categories')->group(function () {
    Route::post('/', [CategoryController::class, 'store'])->name('categories.store');
    Route::put('/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
});

Route::prefix('/products')->group(function () {
    Route::post('/', [ProductController::class, 'store'])->name('products.store');
    Route::put('/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
});

Route::prefix('/cart')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('cart.index');
    Route::post('/{product}', [CartController::class, 'store'])->name('cart.store');
    Route::put('/{cartItem}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/{cartItem}', [CartController::class, 'destroy'])->name('cart.destroy');
});

Route::get('/', [MainPageController::class, 'index'])->name('index');
Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog.index');
