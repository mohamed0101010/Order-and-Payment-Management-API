<?php

namespace App\Services\Payment\Gateways\Gateways;

use App\Services\Payment\Gateways\Contracts\PaymentGatewayInterface;
use App\DTOs\V1\Payment\ProcessPaymentDTO;

class CreditCardGateway implements PaymentGatewayInterface
{
    public function key(): string { return 'credit_card'; }

    public function charge(ProcessPaymentDTO $dto): array
    {
        $success = (bool) random_int(0, 1);

        return [
            'success' => $success,
            'meta' => [
                'provider' => 'credit_card_sim',
                'ref' => 'CC-' . uniqid(),
            ],
        ];
    }
}
