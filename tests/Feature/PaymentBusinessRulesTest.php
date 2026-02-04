<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Order;
use App\Models\PaymentGatewayRegistry;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tymon\JWTAuth\Facades\JWTAuth;

class PaymentBusinessRulesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        PaymentGatewayRegistry::updateOrCreate(
            ['key' => 'credit_card'],
            [
                'enabled' => true,
                'class' => \App\Services\Payment\Gateways\Gateways\CreditCardGateway::class,
                'config' => [],
            ]
        );

        PaymentGatewayRegistry::updateOrCreate(
            ['key' => 'paypal'],
            [
                'enabled' => true,
                'class' => \App\Services\Payment\Gateways\Gateways\PaypalGateway::class,
                'config' => [],
            ]
        );
    }

    public function test_cannot_process_payment_if_order_not_confirmed(): void
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $order = Order::factory()->create(['user_id' => $user->id, 'status' => 'pending']);

        $res = $this->withHeader('Authorization', "Bearer {$token}")
            ->postJson("/api/v1/orders/{$order->id}/payments", [
                'method' => 'credit_card',
                'amount' => 50,
            ]);

        $res->assertStatus(422);
    }

    public function test_can_process_payment_if_order_confirmed(): void
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $order = Order::factory()->confirmed()->create(['user_id' => $user->id]);

        $res = $this->withHeader('Authorization', "Bearer {$token}")
            ->postJson("/api/v1/orders/{$order->id}/payments", [
                'method' => 'paypal',
                'amount' => 50,
            ]);

        $res->assertStatus(201);
    }
}
