<?php

namespace App\DTOs\V1\Order;

class UpdateOrderDTO
{
    public function __construct(
        public readonly ?string $customerName,
        public readonly ?string $customerEmail,
        public readonly ?string $status,
        public readonly ?array $items
    ) {}
}
