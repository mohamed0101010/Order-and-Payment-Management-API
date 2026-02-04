<?php

namespace App\Services\Payment\Gateways\Contracts;

use App\DTOs\V1\Payment\ProcessPaymentDTO;

interface PaymentGatewayInterface
{
    public function key(): string;
    public function charge(ProcessPaymentDTO $dto): array;
}
