<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
{
    public function toArray($request) {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'item_type' => [
                'id' => $this->item_type_id,
                'name' => $this->itemType->name,
            ],
            'media' => $this->media->map(function ($media) {
                $basePath = ($media->disk === 'direct_public')
                    ? "dashboard/uploads/{$media->collection_name}/{$media->file_name}"
                    : "storage/dashboard/uploads/{$media->collection_name}/{$media->file_name}";

                return [
                    'id' => $media->id,
                    'file_name' => $media->file_name,
                    'path' => url($basePath),
                ];
            }),
        ];
    }
}
