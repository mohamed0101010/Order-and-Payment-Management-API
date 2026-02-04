<?php

namespace App\Actions\V1\Auth;

use App\Services\Auth\AuthService;

class LogoutAction
{
    public function __construct(private readonly AuthService $service) {}

    public function execute(): void
    {
        $this->service->logout();
    }
}
