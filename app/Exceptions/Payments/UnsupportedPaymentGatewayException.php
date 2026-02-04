<?php

namespace App\Exceptions\Payments;

use RuntimeException;

class UnsupportedPaymentGatewayException extends RuntimeException
{
    public function __construct(string $method)
    {
        parent::__construct("Unsupported payment gateway: {$method}");
    }
}
