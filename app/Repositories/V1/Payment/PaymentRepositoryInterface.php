<?php

namespace App\Repositories\V1\Payment;

use App\Models\Payment;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface PaymentRepositoryInterface
{
    public function paginate(int $perPage): LengthAwarePaginator;
    
    public function forOrder(int $orderId, int $perPage): LengthAwarePaginator;

    public function create(int $orderId, string $paymentId, string $status, string $method, float $amount, array $meta = []): Payment;
}
