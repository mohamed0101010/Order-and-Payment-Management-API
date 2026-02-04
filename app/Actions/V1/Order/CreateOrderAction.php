<?php

namespace App\Actions\V1\Order;

use App\Services\Order\OrderService;
use App\DTOs\V1\Order\CreateOrderDTO;

class CreateOrderAction
{
    public function __construct(private readonly OrderService $service) {}

    public function execute(CreateOrderDTO $dto)
    {
        return $this->service->create($dto);
    }
}
