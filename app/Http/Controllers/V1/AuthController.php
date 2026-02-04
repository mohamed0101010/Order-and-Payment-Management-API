<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Auth\RegisterRequest;
use App\Http\Requests\V1\Auth\LoginRequest;
use App\Actions\V1\Auth\RegisterAction;
use App\Actions\V1\Auth\LoginAction;
use App\Actions\V1\Auth\LogoutAction;
use App\DTOs\V1\Auth\RegisterDTO;
use App\DTOs\V1\Auth\LoginDTO;

class AuthController extends Controller
{
    public function __construct(
        private readonly RegisterAction $register,
        private readonly LoginAction $login,
        private readonly LogoutAction $logout
    ) {}

    public function register(RegisterRequest $request)
    {
        $dto = new RegisterDTO(
            name: $request->string('name')->toString(),
            email: $request->string('email')->toString(),
            password: $request->string('password')->toString()
        );

        $result = $this->register->execute($dto);

        return api_response($result, 201, 'Registered successfully.');
    }

    public function login(LoginRequest $request)
    {
        $dto = new LoginDTO(
            email: $request->string('email')->toString(),
            password: $request->string('password')->toString()
        );

        $result = $this->login->execute($dto);

        return api_response($result, 200, 'Logged in successfully.');
    }

    public function logout()
    {
        $this->logout->execute();
        return api_response([], 200, 'Logged out.');
    }
}
