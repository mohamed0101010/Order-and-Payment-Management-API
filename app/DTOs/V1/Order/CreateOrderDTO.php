<?php

namespace App\DTOs\V1\Order;

class CreateOrderDTO
{
    public function __construct(
        public readonly int $userId,
        public readonly string $customerName,
        public readonly string $customerEmail,
        public readonly string $status,
        public readonly array $items
    ) {}
}
