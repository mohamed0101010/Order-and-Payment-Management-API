<?php

namespace Tests\Unit\Payment;

use Tests\TestCase;
use App\Services\Payment\PaymentService;
use App\Services\Payment\Gateways\PaymentGatewayManager;
use App\Services\Payment\Gateways\Gateways\CreditCardGateway;
use App\Repositories\V1\Order\OrderRepositoryInterface;
use App\Repositories\V1\Payment\PaymentRepositoryInterface;
use App\DTOs\V1\Payment\ProcessPaymentDTO;
use App\Models\Order;
use App\Models\Payment;
use App\Enums\OrderStatusEnum;
use App\Exceptions\Payments\OrderNotConfirmedException;
use App\Exceptions\Payments\UnsupportedPaymentGatewayException;
use App\Services\Payment\Gateways\Contracts\PaymentGatewayInterface;
use Mockery\MockInterface;

class PaymentServiceTest extends TestCase
{
    private PaymentService $service;
    private MockInterface|OrderRepositoryInterface $orderRepository;
    private MockInterface|PaymentRepositoryInterface $paymentRepository;
    private PaymentGatewayManager $gatewayManager;

    protected function setUp(): void
    {
        parent::setUp();

        $this->orderRepository = \Mockery::mock(OrderRepositoryInterface::class);
        $this->paymentRepository = \Mockery::mock(PaymentRepositoryInterface::class);
        $this->gatewayManager = new PaymentGatewayManager([new CreditCardGateway()]);

        $this->service = new PaymentService(
            $this->orderRepository,
            $this->paymentRepository,
            $this->gatewayManager
        );
    }

    public function test_process_payment_fails_when_order_not_confirmed(): void
    {
        $order = \Mockery::mock(Order::class)->makePartial();
        $order->status = OrderStatusEnum::PENDING;
        $order->id = 1;

        $this->orderRepository
            ->shouldReceive('findWithRelations')
            ->once()
            ->with(1)
            ->andReturn($order);

        $dto = new ProcessPaymentDTO(
            orderId: 1,
            method: 'credit_card',
            amount: 100.00,
            payload: []
        );

        $this->expectException(OrderNotConfirmedException::class);
        $this->service->process($dto);
    }

    public function test_process_payment_succeeds_for_confirmed_order(): void
    {
        $order = \Mockery::mock(Order::class)->makePartial();
        $order->status = OrderStatusEnum::CONFIRMED;
        $order->id = 1;

        $this->orderRepository
            ->shouldReceive('findWithRelations')
            ->once()
            ->with(1)
            ->andReturn($order);

        $payment = \Mockery::mock(Payment::class)->makePartial();
        $this->paymentRepository
            ->shouldReceive('create')
            ->once()
            ->andReturn($payment);

        $dto = new ProcessPaymentDTO(
            orderId: 1,
            method: 'credit_card',
            amount: 100.00,
            payload: []
        );

        $result = $this->service->process($dto);

        $this->assertNotNull($result);
    }

    public function test_process_payment_creates_payment_record_with_correct_data(): void
    {
        $order = \Mockery::mock(Order::class)->makePartial();
        $order->status = OrderStatusEnum::CONFIRMED;
        $order->id = 1;

        $this->orderRepository
            ->shouldReceive('findWithRelations')
            ->once()
            ->with(1)
            ->andReturn($order);

        $payment = \Mockery::mock(Payment::class)->makePartial();
        $this->paymentRepository
            ->shouldReceive('create')
            ->once()
            ->withArgs(function ($orderId, $paymentId, $status, $method, $amount) {
                return $orderId === 1
                    && strpos($paymentId, 'CREDIT_CARD-') === 0
                    && in_array($status, ['pending', 'successful', 'failed'])
                    && $method === 'credit_card'
                    && $amount === 100.00;
            })
            ->andReturn($payment);

        $dto = new ProcessPaymentDTO(
            orderId: 1,
            method: 'credit_card',
            amount: 100.00,
            payload: []
        );

        $result = $this->service->process($dto);
        $this->assertNotNull($result);
    }

    public function test_process_payment_uses_correct_gateway(): void
    {
        $order = \Mockery::mock(Order::class)->makePartial();
        $order->status = OrderStatusEnum::CONFIRMED;
        $order->id = 1;

        $this->orderRepository
            ->shouldReceive('findWithRelations')
            ->once()
            ->with(1)
            ->andReturn($order);

        $payment = \Mockery::mock(Payment::class)->makePartial();
        $this->paymentRepository
            ->shouldReceive('create')
            ->once()
            ->andReturn($payment);

        $dto = new ProcessPaymentDTO(
            orderId: 1,
            method: 'credit_card',
            amount: 100.00,
            payload: []
        );

        $result = $this->service->process($dto);
        
        $this->assertNotNull($result);
    }

    public function test_process_payment_throws_on_unsupported_gateway(): void
    {
        $order = \Mockery::mock(Order::class)->makePartial();
        $order->status = OrderStatusEnum::CONFIRMED;
        $order->id = 2;

        $this->orderRepository
            ->shouldReceive('findWithRelations')
            ->once()
            ->with(2)
            ->andReturn($order);

        $this->gatewayManager = new \App\Services\Payment\Gateways\PaymentGatewayManager([new \App\Services\Payment\Gateways\Gateways\CreditCardGateway()]);
        $service = new \App\Services\Payment\PaymentService($this->orderRepository, $this->paymentRepository, $this->gatewayManager);

        $dto = new ProcessPaymentDTO(orderId: 2, method: 'unsupported', amount: 50.00, payload: []);

        $this->expectException(UnsupportedPaymentGatewayException::class);
        $service->process($dto);
    }

    public function test_gateway_failure_results_in_failed_status_and_meta_passed(): void
    {
        $order = \Mockery::mock(Order::class)->makePartial();
        $order->status = OrderStatusEnum::CONFIRMED;
        $order->id = 3;
        $order->total = 100.00;

        $this->orderRepository
            ->shouldReceive('findWithRelations')
            ->once()
            ->with(3)
            ->andReturn($order);

        $gatewayMock = \Mockery::mock(PaymentGatewayInterface::class);
        $gatewayMock->shouldReceive('key')->andReturn('mock_gateway');
        $gatewayMock->shouldReceive('charge')->andReturn([ 'success' => false, 'meta' => ['provider' => 'mock', 'ref' => 'MOCK-1'] ]);

        $managerMock = \Mockery::mock(\App\Services\Payment\Gateways\PaymentGatewayManager::class);
        $managerMock->shouldReceive('resolve')->with('mock_gateway')->andReturn($gatewayMock);

        $this->paymentRepository
            ->shouldReceive('create')
            ->once()
            ->withArgs(function ($orderId, $paymentId, $status, $method, $amount, $meta) {
                return $orderId === 3
                    && $method === 'mock_gateway'
                    && $status === \App\Enums\PaymentStatusEnum::FAILED->value
                    && is_array($meta)
                    && $meta['ref'] === 'MOCK-1';
            })
            ->andReturn(\Mockery::mock(Payment::class));

        $service = new \App\Services\Payment\PaymentService($this->orderRepository, $this->paymentRepository, $managerMock);

        $dto = new ProcessPaymentDTO(orderId: 3, method: 'mock_gateway', amount: 100.00, payload: []);

        $result = $service->process($dto);
        $this->assertNotNull($result);
    }

    protected function tearDown(): void
    {
        \Mockery::close();
        parent::tearDown();
    }
}

