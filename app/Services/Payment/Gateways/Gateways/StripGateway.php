<?php

namespace App\Services\Payment\Gateways\Gateways;

use App\Services\Payment\Gateways\Contracts\PaymentGatewayInterface;
use App\DTOs\V1\Payment\ProcessPaymentDTO;

class StripGateway implements PaymentGatewayInterface
{
    public function key(): string
    {
        return 'strip';
    }

    public function charge(ProcessPaymentDTO $dto): array
    {
        // Simulate StripGateway charge with success/failure
        $success = (bool) random_int(0, 1);

        return [
            'success' => $success,
            'meta' => [
                'provider' => 'strip',
                'ref' => strtoupper('strip') . '-' . uniqid(),
            ],
        ];
    }
}