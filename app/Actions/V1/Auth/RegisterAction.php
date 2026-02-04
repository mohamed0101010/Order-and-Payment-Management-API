<?php

namespace App\Actions\V1\Auth;

use App\DTOs\V1\Auth\RegisterDTO;
use App\Services\Auth\AuthService;

class RegisterAction
{
    public function __construct(private readonly AuthService $service) {}

    public function execute(RegisterDTO $dto): array
    {
        return $this->service->register($dto);
    }
}
