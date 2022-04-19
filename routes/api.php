<?php

use App\Http\Controllers\Api\ImageController;
use Illuminate\Support\Facades\Route;

Route::get('/images', [ImageController::class, 'index'])->name('images.index')->middleware('auth:sanctum');
Route::get('/images/{id}', [ImageController::class, 'show'])->name('images.show')->middleware('auth:sanctum');

Route::post('/images/store', [ImageController::class, 'store'])->name('images.store')->middleware('auth:sanctum');
