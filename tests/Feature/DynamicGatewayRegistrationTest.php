<?php

namespace Tests\Feature;

use App\Services\Payment\Gateways\Gateways\DynamicGateway;
use App\DTOs\V1\Payment\ProcessPaymentDTO;
use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Tests\TestCase;

class DynamicGatewayRegistrationTest extends TestCase
{
    public function test_dynamic_gateway_without_class_file()
    {
        $overrideConfig = [
            'key' => 'good',
            'provider' => 'goodpay',
            'api_key' => 'test_key_123',
        ];

        $repo = $this->app->make(ConfigRepository::class);
        $dynamicGateway = new DynamicGateway($repo, $overrideConfig);

        $this->assertEquals('good', $dynamicGateway->key());

        $dto = new ProcessPaymentDTO(
            orderId: 1,
            method: 'good',
            amount: 100,
            payload: ['order_id' => 123]
        );

        $result = $dynamicGateway->charge($dto);

        $this->assertTrue(in_array($result['success'], [true, false], true));
        $this->assertNotEmpty($result['meta']['ref']);
        $this->assertIsArray($result['meta']);
    }

    public function test_dynamic_gateway_with_different_amounts()
    {
        $repo = $this->app->make(ConfigRepository::class);
        $gateway = new DynamicGateway($repo, ['key' => 'good']);

        $dto1 = new ProcessPaymentDTO(orderId: 1, method: 'good', amount: 50, payload: []);
        $dto2 = new ProcessPaymentDTO(orderId: 2, method: 'good', amount: 150, payload: []);

        $result1 = $gateway->charge($dto1);
        $result2 = $gateway->charge($dto2);

        $this->assertNotEmpty($result1['meta']['ref']);
        $this->assertNotEmpty($result2['meta']['ref']);
        $this->assertNotEmpty($result2['meta']['ref']);
        $this->assertNotEquals($result1['meta']['ref'], $result2['meta']['ref']);
    }

    public function test_dynamic_gateway_returns_consistent_key()
    {
        $repo = $this->app->make(ConfigRepository::class);
        $gateway = new DynamicGateway($repo, ['key' => 'stripe_dynamic']);

        $this->assertEquals('stripe_dynamic', $gateway->key());
        $this->assertEquals('stripe_dynamic', $gateway->key());
    }
}
