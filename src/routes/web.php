<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/categories', [CategoryController::class, 'store']);
Route::put('/categories/{category}', [CategoryController::class, 'update']);
Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);
