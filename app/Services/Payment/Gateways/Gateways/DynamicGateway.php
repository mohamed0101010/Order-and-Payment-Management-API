<?php

namespace App\Services\Payment\Gateways\Gateways;

use App\Services\Payment\Gateways\Contracts\PaymentGatewayInterface;
use App\DTOs\V1\Payment\ProcessPaymentDTO;
use Illuminate\Contracts\Config\Repository as ConfigRepository;

class DynamicGateway implements PaymentGatewayInterface
{
    private array $config = [];

    public function __construct(ConfigRepository $repo, array $overrideConfig = [])
    {
        $base = $repo->get('payment.gateways.dynamic', []);
        $this->config = array_merge($base, $overrideConfig);
    }

    public function key(): string
    {
        return strtolower((string) ($this->config['key'] ?? 'dynamic'));
    }

    public function charge(ProcessPaymentDTO $dto): array
    {
        $key = $this->key();
        $success = (bool) random_int(0, 1);

        return [
            'success' => $success,
            'meta' => [
                'provider' => $key,
                'ref' => strtoupper($key) . '-' . uniqid(),
            ],
        ];
    }
}
