<?php

use App\Http\Controllers\Api\ApiTokenController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::post('/tokens/create', [ApiTokenController::class, 'create'])->name('token.create');
Route::delete('/tokens/delete/{id}', [ApiTokenController::class, 'delete'])->name('token.delete');


