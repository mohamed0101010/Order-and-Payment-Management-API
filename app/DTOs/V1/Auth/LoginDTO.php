<?php

namespace App\DTOs\V1\Auth;

class LoginDTO
{
    public function __construct(
        public readonly string $email,
        public readonly string $password
    ) {}
}
