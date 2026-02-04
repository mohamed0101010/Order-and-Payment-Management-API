<?php

namespace App\Services\Order;

use App\Models\Order;
use App\Repositories\V1\Order\OrderRepositoryInterface;
use App\Exceptions\Orders\OrderCannotBeDeletedException;
use App\DTOs\V1\Order\CreateOrderDTO;
use App\DTOs\V1\Order\UpdateOrderDTO;

class OrderService
{
    public function __construct(private readonly OrderRepositoryInterface $orders) {}

    public function create(CreateOrderDTO $dto): Order
    {
        return $this->orders->create($dto);
    }

    public function update(Order $order, UpdateOrderDTO $dto): Order
    {
        return $this->orders->update($order, $dto);
    }

    public function delete(Order $order): void
    {
        if ($order->payments()->exists()) {
            throw new OrderCannotBeDeletedException();
        }
        $this->orders->delete($order);
    }
}
