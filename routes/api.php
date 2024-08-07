<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use \App\Http\Middleware\JwtVerifyMiddleware;
Route::post('/auth', [AuthController::class, 'authenticate']);
Route::post('/register', [AuthController::class, 'registration']);

Route::middleware([JwtVerifyMiddleware::class])->group(function () {
    Route::get('/me', function () {
        return \App\Helpers\ApiResponse::sendResponse(['user' => auth()->user()]);
    });
    Route::post('/logout', [AuthController::class, 'logout']);
});
