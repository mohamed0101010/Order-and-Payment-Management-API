<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'customer_name' => $this->faker->name(),
            'customer_email' => $this->faker->safeEmail(),
            'status' => 'pending',
            'total' => 0,
        ];
    }

    public function confirmed(): self
    {
        return $this->state(fn() => ['status' => 'confirmed']);
    }
}
