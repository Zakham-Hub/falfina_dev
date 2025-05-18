<?php

namespace App\Dto;

use App\Http\Requests\Api\AuthRequests\LoginRequest;
use App\Http\Requests\Api\AuthRequests\RegisterRequest;

class UserDto
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
    ) {}

    public static function createFromRegisterRequest(RegisterRequest $request): UserDto
    {
        return new self(
            name: $request->name,
            email: $request->email,
            password: bcrypt($request->password),
        );
    }

    public static function createFromLoginRequest(LoginRequest $request): UserDto
    {
        return new self(
            name: '',
            email: $request->email,
            password: $request->password,
        );
    }
}
