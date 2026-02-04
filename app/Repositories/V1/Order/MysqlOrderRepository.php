<?php

namespace App\Repositories\V1\Order;

use App\Models\Order;
use App\Models\OrderItem;
use App\DTOs\V1\Order\CreateOrderDTO;
use App\DTOs\V1\Order\UpdateOrderDTO;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class MysqlOrderRepository implements OrderRepositoryInterface
{
    public function paginate(?string $status, int $perPage): LengthAwarePaginator
    {
        return Order::query()
            ->when($status, fn($q) => $q->where('status', $status))
            ->with('items')
            ->latest()
            ->paginate($perPage);
    }

    public function findWithRelations(int $id): Order
    {
        return Order::with(['items','payments'])->findOrFail($id);
    }

    public function create(CreateOrderDTO $dto): Order
    {
        return DB::transaction(function () use ($dto) {
            $order = Order::create([
                'user_id' => $dto->userId,
                'customer_name' => $dto->customerName,
                'customer_email' => $dto->customerEmail,
                'status' => $dto->status,
                'total' => 0,
            ]);

            $total = 0;
            foreach ($dto->items as $item) {
                $line = $item['quantity'] * $item['price'];
                $total += $line;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_name' => $item['product_name'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'line_total' => $line,
                ]);
            }

            $order->update(['total' => $total]);

            return $order->load('items');
        });
    }

    public function update(Order $order, UpdateOrderDTO $dto): Order
    {
        return DB::transaction(function () use ($order, $dto) {

            $order->update(array_filter([
                'customer_name' => $dto->customerName,
                'customer_email' => $dto->customerEmail,
                'status' => $dto->status,
            ], fn($v) => !is_null($v)));

            if (is_array($dto->items)) {
                $order->items()->delete();

                $total = 0;
                foreach ($dto->items as $item) {
                    $line = $item['quantity'] * $item['price'];
                    $total += $line;

                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_name' => $item['product_name'],
                        'quantity' => $item['quantity'],
                        'price' => $item['price'],
                        'line_total' => $line,
                    ]);
                }

                $order->update(['total' => $total]);
            }

            return $order->refresh()->load('items');
        });
    }

    public function delete(Order $order): void
    {
        $order->delete();
    }
}
