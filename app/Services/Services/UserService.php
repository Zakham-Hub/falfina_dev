<?php

namespace App\Services\Services;

use App\Dto\UserDto;
use App\Repositories\UserRepository;
use App\Services\Contracts\UserInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class UserService implements UserInterface
{
    protected UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository;
    }

    public function register(UserDto $userDto)
    {
        return $this->userRepository->create($userDto);
    }

    public function login(UserDto $userDto)
    {
        if (Auth::attempt(['email' => $userDto->email, 'password' => $userDto->password])) {
            $user = Auth::user();
            $tokenResult = $user->createToken('authToken');
            $token = $tokenResult->accessToken;

            // Get the token's expiration time
            $expiresAt = Carbon::parse($tokenResult->token->expires_at)->toDateTimeString();

            return [
                'user' => $user,
                'token' => $token,
                'expires_at' => $expiresAt, // Include the expiration time
            ];
        }

        return null;
    }
}
