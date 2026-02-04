<?php

namespace App\Actions\V1\Auth;

use App\DTOs\V1\Auth\LoginDTO;
use App\Services\Auth\AuthService;

class LoginAction
{
    public function __construct(private readonly AuthService $service) {}

    public function execute(LoginDTO $dto): array
    {
        return $this->service->login($dto);
    }
}
