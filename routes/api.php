<?php

use App\Http\Controllers\Api\ImageController;
use App\Http\Controllers\Api\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/images', [ImageController::class, 'index'])->name('images.index')->middleware('auth:sanctum');
Route::get('/images/{id}', [ImageController::class, 'show'])->name('images.show')->middleware('auth:sanctum');

Route::post('/store', [ImageController::class, 'store'])->name('images.store')->middleware('auth:sanctum');
