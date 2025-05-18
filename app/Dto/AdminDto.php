<?php

namespace App\Dto;

use App\Http\Requests\AdminRequests\CreateRequest;

class AdminDto
{
    public function __construct(
        public string $name,
        public string $email,
        public readonly ?string $password, // Make password nullable
        public readonly ?string $phone,
        public string $status,
        public string $type,
        public bool $link_password_status = false,
        public ?string $link_password_protection = null,
    ) {}

    public static function create(CreateRequest $request): AdminDto
    {
        return new self(
            name: $request->name,
            email: $request->email,
            password: $request->password,
            phone: $request->phone,
            status: $request->status,
            type: $request->type,
            link_password_status: (bool) $request->link_password_status,
            link_password_protection: bcrypt($request->link_password_protection),
        );
    }
}
