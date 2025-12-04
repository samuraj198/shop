<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\MainPageController;

Route::get('/', [MainPageController::class, 'index']);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::delete('/logout', [AuthController::class, 'logout']);

Route::prefix('/categories')->group(function () {
    Route::post('/', [CategoryController::class, 'store']);
    Route::put('/{category}', [CategoryController::class, 'update']);
    Route::delete('/{category}', [CategoryController::class, 'destroy']);
});

Route::prefix('/products')->group(function () {
    Route::post('/', [ProductController::class, 'store']);
    Route::put('/{product}', [ProductController::class, 'update']);
    Route::delete('/{product}', [ProductController::class, 'destroy']);
});

Route::prefix('/cart')->group(function () {
    Route::get('/', [CartController::class, 'index']);
    Route::post('/{product}', [CartController::class, 'store']);
    Route::put('/{cartItem}', [CartController::class, 'update']);
    Route::delete('/{cartItem}', [CartController::class, 'destroy']);
});

Route::get('/catalog', [CatalogController::class, 'index']);
