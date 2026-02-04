<?php

namespace App\DTOs\V1\Payment;

class ProcessPaymentDTO
{
    public int $orderId;
    public string $method;
    public float $amount;
    public array $payload;

    public function __construct(int $orderId, string $method, float $amount, array $payload = [])
    {
        $this->orderId = $orderId;
        $this->method = $method;
        $this->amount = $amount;
        $this->payload = $payload;
    }
}
