<?php

use App\Http\Controllers\Api\ImageController;
use Illuminate\Support\Facades\Route;

Route::get('/images', [ImageController::class, 'index']);
Route::get('/images/{id}', [ImageController::class, 'show'])->name('images.show');

Route::post('/store', [ImageController::class, 'store'])->name('images.store');

