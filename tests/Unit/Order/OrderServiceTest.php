<?php

namespace Tests\Unit\Order;

use Tests\TestCase;
use App\Services\Order\OrderService;
use App\Repositories\V1\Order\OrderRepositoryInterface;
use App\Exceptions\Orders\OrderCannotBeDeletedException;
use App\Models\Order;
use App\Models\Payment;
use Mockery\MockInterface;

class OrderServiceTest extends TestCase
{
    private OrderService $service;
    private OrderRepositoryInterface&MockInterface $orderRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->orderRepository = \Mockery::mock(OrderRepositoryInterface::class);
        $this->service = new OrderService($this->orderRepository);
    }

    public function test_delete_order_fails_when_payments_exist(): void
    {
        $order = \Mockery::mock(Order::class);
        $order->shouldReceive('payments->exists')
            ->once()
            ->andReturn(true);

        $this->expectException(OrderCannotBeDeletedException::class);
        $this->service->delete($order);
    }

    public function test_delete_order_succeeds_when_no_payments(): void
    {
        $order = \Mockery::mock(Order::class);
        $order->shouldReceive('payments->exists')
            ->once()
            ->andReturn(false);

        $this->orderRepository
            ->shouldReceive('delete')
            ->once()
            ->with($order);

        $this->service->delete($order);
        $this->assertTrue(true);
    }

    public function test_delete_order_calls_repository(): void
    {
        $order = \Mockery::mock(Order::class);
        $order->shouldReceive('payments->exists')
            ->once()
            ->andReturn(false);

        $this->orderRepository
            ->shouldReceive('delete')
            ->once()
            ->with($order);

        $this->service->delete($order);
        $this->assertTrue(true);
    }

    public function test_cannot_delete_order_with_payments(): void
    {
        $order = \Mockery::mock(Order::class);
        $order->shouldReceive('payments->exists')
            ->once()
            ->andReturn(true);

        $this->expectException(OrderCannotBeDeletedException::class);
        $this->service->delete($order);
    }

    protected function tearDown(): void
    {
        \Mockery::close();
        parent::tearDown();
    }
}

