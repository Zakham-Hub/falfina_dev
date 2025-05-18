<?php

namespace App\Dto;

use App\Http\Requests\SizeRequests\CreateRequest;

class SizeDto
{
    public function __construct(
        public string $name,
        public ?int $gram = null,
    ) {}

    public static function create(CreateRequest $request): SizeDto
    {
        return new self(
            name: $request->name,
            gram: $request->gram,
        );
    }
}
