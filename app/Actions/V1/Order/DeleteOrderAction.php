<?php

namespace App\Actions\V1\Order;

use App\Models\Order;
use App\Services\Order\OrderService;

class DeleteOrderAction
{
    public function __construct(private readonly OrderService $service) {}

    public function execute(Order $order): void
    {
        $this->service->delete($order);
    }
}
