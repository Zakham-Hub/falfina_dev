<?php

namespace App\Dto;

use App\Http\Requests\CategoryRequests\CreateRequest;

class CategoryDto
{
    public function __construct(
        public string $name,
    ) {}

    public static function create(CreateRequest $request): CategoryDto
    {
        return new self(
            name: $request->name,
        );
    }
}
