<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V1\PaymentController;

Route::middleware('jwt.auth')->group(function () {
    Route::post('orders/{order}/payments', [PaymentController::class, 'process']);
    Route::get('orders/{order}/payments', [PaymentController::class, 'orderPayments']);
    Route::get('payments', [PaymentController::class, 'index']);
    Route::post('payment-gateways', [PaymentController::class, 'registerGateway']);
});
