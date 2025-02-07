<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum', 'isAdmin'])->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    
    Route::get('/create-writer', [ApiController::class, 'createOrUpdate']);

    Route::put('/update-writer/{id}', [ApiController::class, 'createOrUpdate']);

    Route::get('/delete-writer/{id}', [ApiController::class, 'delete']);

    Route::get('/get-writer', [ApiController::class, 'get']);

    Route::get('/get-writer-books/{id}', [ApiController::class, 'getLivrosAutor']);

    Route::post('/logout', [AuthController::class, 'logout']);
});
