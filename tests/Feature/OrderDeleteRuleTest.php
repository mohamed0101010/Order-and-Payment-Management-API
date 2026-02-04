<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tymon\JWTAuth\Facades\JWTAuth;

class OrderDeleteRuleTest extends TestCase
{
    use RefreshDatabase;

    public function test_cannot_delete_order_with_payments(): void
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $order = Order::factory()->create(['user_id' => $user->id]);
        Payment::factory()->create(['order_id' => $order->id]);

        $res = $this->withHeader('Authorization', "Bearer {$token}")
            ->deleteJson("/api/v1/orders/{$order->id}");

        $res->assertStatus(409);
    }
}
