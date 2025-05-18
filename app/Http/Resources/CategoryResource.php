<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource {
    public function toArray($request) {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'parent_id' => $this->parent_id,
            'description' => $this->description,
            'short_description' => $this->short_description,
            'media' => $this->getMediaUrl('category'),
            'children' => CategoryResource::collection($this->whenLoaded('childrenRecursive'))
        ];
    }
}
