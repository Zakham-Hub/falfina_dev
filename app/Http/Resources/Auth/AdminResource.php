<?php

namespace App\Http\Resources\Auth;

use App\Http\Resources\Profile;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'type'  => 'Admin',
            'profile' => new Profile\AdminProfileResource($this->whenLoaded('profile')),
        ];
    }
}
