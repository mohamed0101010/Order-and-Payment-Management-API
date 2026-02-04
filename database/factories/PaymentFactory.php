<?php

namespace Database\Factories;

use App\Models\Payment;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    public function definition(): array
    {
        return [
            'payment_id' => 'PAY-' . uniqid(),
            'order_id' => Order::factory(),
            'status' => 'successful',
            'method' => 'credit_card',
            'amount' => 100,
            'meta' => ['ref' => 'X'],
        ];
    }
}
