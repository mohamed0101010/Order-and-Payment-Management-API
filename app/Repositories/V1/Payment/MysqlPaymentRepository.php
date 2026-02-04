<?php

namespace App\Repositories\V1\Payment;

use App\Models\Payment;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class MysqlPaymentRepository implements PaymentRepositoryInterface
{
    public function paginate(int $perPage): LengthAwarePaginator
    {
        return Payment::query()
            ->with('order')
            ->latest()
            ->paginate($perPage);
    }

    public function forOrder(int $orderId, int $perPage): LengthAwarePaginator
    {
        return Payment::query()
            ->where('order_id', $orderId)
            ->latest()
            ->paginate($perPage);
    }

    public function create(
        int $orderId,
        string $paymentId,
        string $status,
        string $method,
        float $amount,
        array $meta = []
    ): Payment {
        return Payment::create([
            'order_id' => $orderId,
            'payment_id' => $paymentId,
            'status' => $status,
            'method' => $method,
            'amount' => $amount,
            'meta' => $meta,
        ]);
    }
}
