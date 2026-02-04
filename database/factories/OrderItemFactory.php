<?php

namespace Database\Factories;

use App\Models\OrderItem;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemFactory extends Factory
{
    protected $model = OrderItem::class;

    public function definition(): array
    {
        $qty = $this->faker->numberBetween(1, 5);
        $price = $this->faker->randomFloat(2, 10, 200);

        return [
            'order_id' => Order::factory(),
            'product_name' => $this->faker->word(),
            'quantity' => $qty,
            'price' => $price,
            'line_total' => $qty * $price,
        ];
    }
}
