<?php

namespace App\Services\Payment\Gateways;

use App\Services\Payment\Gateways\Contracts\PaymentGatewayInterface;
use App\Exceptions\Payments\UnsupportedPaymentGatewayException;

class PaymentGatewayManager
{
    /** @var array<string, PaymentGatewayInterface> */
    private array $map = [];

    public function __construct(iterable $gateways)
    {
        foreach ($gateways as $gateway) {
            $this->map[strtolower($gateway->key())] = $gateway;
        }
    }
    
    

    public function keys(): array
    {
        return array_keys($this->map);
    }
    public function resolve(string $method): PaymentGatewayInterface
    {
        $method = strtolower($method);
    
        if (!isset($this->map[$method])) {
            throw new UnsupportedPaymentGatewayException($method);
        }
    
        return $this->map[$method];
    }
    
}
