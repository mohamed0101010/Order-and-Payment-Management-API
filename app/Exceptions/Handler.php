<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Throwable;
use Illuminate\Auth\AuthenticationException;

use App\Exceptions\Orders\OrderCannotBeDeletedException;
use App\Exceptions\Payments\OrderNotConfirmedException;
use App\Exceptions\Payments\UnsupportedPaymentGatewayException;

class Handler extends ExceptionHandler
{
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register(): void
    {
        $this->renderable(function (OrderNotConfirmedException $e, $request) {
            return api_response([], 422, $e->getMessage());
        });

        $this->renderable(function (OrderCannotBeDeletedException $e, $request) {
            return api_response([], 409, $e->getMessage());
        });

        $this->renderable(function (UnsupportedPaymentGatewayException $e, $request) {
            return api_response([], 422, $e->getMessage());
        });

        $this->renderable(function (ValidationException $e, $request) {
            return api_response(['errors' => $e->errors()], 422, 'Validation error.');
        });
        $this->renderable(function (AuthenticationException $e, $request) {
            return api_response([], 401, 'Unauthenticated.');
        });
    }
}
