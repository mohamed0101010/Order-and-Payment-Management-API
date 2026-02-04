<?php

namespace App\Actions\V1\Payment;

use App\Services\Payment\PaymentService;
use App\DTOs\V1\Payment\ProcessPaymentDTO;

class ProcessPaymentAction
{
    public function __construct(private readonly PaymentService $service) {}

    public function execute(ProcessPaymentDTO $dto)
    {
        return $this->service->process($dto);
    }
}
