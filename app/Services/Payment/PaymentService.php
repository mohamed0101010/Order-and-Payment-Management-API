<?php

namespace App\Services\Payment;

use App\DTOs\V1\Payment\ProcessPaymentDTO;
use App\Enums\OrderStatusEnum;
use App\Enums\PaymentStatusEnum;
use App\Exceptions\Payments\OrderNotConfirmedException;
use App\Repositories\V1\Order\OrderRepositoryInterface;
use App\Repositories\V1\Payment\PaymentRepositoryInterface;
use App\Services\Payment\Gateways\PaymentGatewayManager;

class PaymentService
{
    public function __construct(
        private readonly OrderRepositoryInterface $orders,
        private readonly PaymentRepositoryInterface $payments,
        private readonly PaymentGatewayManager $manager
    ) {}

    public function process(ProcessPaymentDTO $dto)
    {
        $order = $this->orders->findWithRelations($dto->orderId);

        if ($order->status !== OrderStatusEnum::CONFIRMED) {
            throw new OrderNotConfirmedException();
        }

        if (property_exists($order, 'total') && bccomp((string)$dto->amount, (string)$order->total, 2) !== 0) {
            throw new \App\Exceptions\Payments\InvalidPaymentAmountException();
        }

        $gateway = $this->manager->resolve($dto->method);
        $method  = $gateway->key();

        $result = $gateway->charge($dto);

        $status = $result['success']
            ? PaymentStatusEnum::SUCCESSFUL->value
            : PaymentStatusEnum::FAILED->value;

        $paymentId = strtoupper($method) . '-' . uniqid();

        return $this->payments->create(
            orderId: $order->id,
            paymentId: $paymentId,
            status: $status,
            method: $method,
            amount: $dto->amount,
            meta: $result['meta'] ?? []
        );
    }
}
