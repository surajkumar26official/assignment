<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ShortUrlController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/urls', [ShortUrlController::class, 'listShortUrl']);
    Route::post('/urls', [ShortUrlController::class, 'urlShort']);
    Route::get('/r/{code}', [ShortUrlController::class, 'redirect']);
});
