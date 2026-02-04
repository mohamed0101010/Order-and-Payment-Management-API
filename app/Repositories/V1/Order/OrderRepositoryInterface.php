<?php

namespace App\Repositories\V1\Order;

use App\Models\Order;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\DTOs\V1\Order\CreateOrderDTO;
use App\DTOs\V1\Order\UpdateOrderDTO;

interface OrderRepositoryInterface
{
    public function paginate(?string $status, int $perPage): LengthAwarePaginator;

    public function findWithRelations(int $id): Order;

    public function create(CreateOrderDTO $dto): Order;

    public function update(Order $order, UpdateOrderDTO $dto): Order;
    
    public function delete(Order $order): void;
}
