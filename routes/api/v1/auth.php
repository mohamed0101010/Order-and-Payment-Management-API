<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V1\AuthController;

Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::middleware('jwt.auth')->post('logout', [AuthController::class, 'logout']);
});
