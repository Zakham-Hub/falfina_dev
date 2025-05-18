<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource {
    public function toArray($request) {
        // Attach items to each item type
        $itemTypes = $this->whenLoaded('itemTypes', function () {
            return $this->itemTypes->map(function ($itemType) {
                // Filter items for this item type
                $itemType->items = $this->items->where('item_type_id', $itemType->id);
                return $itemType;
            });
        });

        return [

            'id' => $this->id,
            'name' => $this->name,
            'alt_name' => $this->alt_name,
            'description' => $this->description,
            'short_description' => $this->short_description,
            'loyalty_points' => $this->loyalty_points,
            'price' => $this->price,
            'categories' => $this->categories->map(function ($category) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                ];
            }),
            'sizes' => $this->sizes->map(function ($size) {
                return [
                    'id' => $size->id,
                    'name' => $size->name,
                    'price' => $size->pivot->price,
                ];
            }),
            'types' => $this->types->map(function ($type) {
                return [
                    'id' => $type->id,
                    'name' => $type->name,
                ];
            }),
            'extras' => $this->extras->map(function ($extra) {
                return [
                    'id' => $extra->id,
                    'name' => $extra->name,
                    'type' => $extra->type,
                    'price' => $extra->price,
                ];
            }),
            'media' => $this->getMediaUrl('product'),

        ];
    }
}
