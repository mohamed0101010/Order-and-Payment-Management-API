<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tymon\JWTAuth\Facades\JWTAuth;

class OrdersApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_order(): void
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $res = $this->withHeader('Authorization', "Bearer {$token}")
            ->postJson('/api/v1/orders', [
                'customer_name' => 'Mohamed',
                'customer_email' => 'm@example.com',
                'status' => 'pending',
                'items' => [
                    ['product_name' => 'A', 'quantity' => 2, 'price' => 10],
                    ['product_name' => 'B', 'quantity' => 1, 'price' => 5],
                ],
            ]);

        $res->assertStatus(201);
        $this->assertDatabaseHas('orders', ['customer_email' => 'm@example.com']);
        $this->assertDatabaseHas('order_items', ['product_name' => 'A']);
    }

    public function test_can_filter_orders_by_status(): void
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        Order::factory()->create(['user_id' => $user->id, 'status' => 'pending']);
        Order::factory()->create(['user_id' => $user->id, 'status' => 'confirmed']);

        $res = $this->withHeader('Authorization', "Bearer {$token}")
            ->getJson('/api/v1/orders?status=confirmed');

        $res->assertStatus(200);
    }
}
