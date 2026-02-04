<?php

namespace App\Services\Auth;

use App\DTOs\V1\Auth\RegisterDTO;
use App\DTOs\V1\Auth\LoginDTO;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService
{
    public function register(RegisterDTO $dto): array
    {
        $user = User::create([
            'name' => $dto->name,
            'email' => $dto->email,
            'password' => Hash::make($dto->password),
        ]);

        $token = JWTAuth::fromUser($user);

        return [
            'token' => $token,
            'user' => $user,
        ];
    }
    public function login(LoginDTO $dto): array
    {
        $credentials = [
            'email' => $dto->email,
            'password' => $dto->password,
        ];

        if (!$token = JWTAuth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => ['Invalid credentials.'],
            ]);
        }

        $user = JWTAuth::setToken($token)->toUser();

        return [
            'token' => $token,
            'user' => $user,
        ];
    }

    public function logout(): void
    {
        JWTAuth::invalidate(JWTAuth::getToken());
    }



}
