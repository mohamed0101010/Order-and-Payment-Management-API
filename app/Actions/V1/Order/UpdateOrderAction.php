<?php

namespace App\Actions\V1\Order;

use App\Models\Order;
use App\Services\Order\OrderService;
use App\DTOs\V1\Order\UpdateOrderDTO;

class UpdateOrderAction
{
    public function __construct(private readonly OrderService $service) {}

    public function execute(Order $order, UpdateOrderDTO $dto): Order
    {
        return $this->service->update($order, $dto);
    }
}
