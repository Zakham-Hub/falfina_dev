<?php

namespace App\Dto;

use App\Http\Requests\ProductRequests\CreateRequest;
use Illuminate\Http\UploadedFile;

class ProductDto
{
    public function __construct(
        public string $name,
        public string $description,
        public int $category_id,
        public string $type,
        public float $price,
        public ?array $sizes = null,
        public ?array $items = null,
        public ?array $itemTypes = null,
        public ?UploadedFile $image = null,

    ) {}

    public static function create(CreateRequest $request): ProductDto
    {
        return new self(
            name: $request->name,
            description: $request->description,
            category_id: $request->category_id,
            type: $request->type,
            price: $request->price,
            sizes: $request->sizes,
            items: $request->items,
            itemTypes: $request->item_types,
            image: $request->image,

        );
    }

    public function only(array $keys): array
    {
        return array_intersect_key((array) $this, array_flip($keys));
    }
}
