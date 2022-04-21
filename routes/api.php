<?php

use App\Http\Controllers\Api\ImageController;
use Illuminate\Support\Facades\Route;



Route::get('/images/{id}', [ImageController::class, 'show'])->name('images.show')->middleware('auth:sanctum');

Route::post('/images/store', [ImageController::class, 'store'])->name('images.store')->middleware('auth:sanctum');

Route::put('/images/{id}/edit', [ImageController::class, 'edit'])->name('images.edit')->middleware('auth:sanctum');

Route::delete('/images/{id}/delete', [ImageController::class, 'delete'])->name('images.delete')->middleware('auth:sanctum');
