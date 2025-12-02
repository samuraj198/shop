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
Route::post('/categories', [CategoryController::class, 'store']);
Route::put('/categories/{category}', [CategoryController::class, 'update']);
Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);
Route::post('/products', [ProductController::class, 'store']);
Route::put('/products/{product}', [ProductController::class, 'update']);
Route::delete('/products/{product}', [ProductController::class, 'destroy']);

Route::get('/cart', [ProductController::class, 'index']);
Route::post('/cart/{product}', [CartController::class, 'store']);
Route::put('/cart/{cartItem}', [CartController::class, 'update']);
Route::delete('/cart/{cartItem}', [CartController::class, 'destroy']);

Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog');
