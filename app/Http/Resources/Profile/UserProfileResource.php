<?php

namespace App\Http\Resources\Profile;
use Illuminate\Http\Resources\Json\JsonResource;
class UserProfileResource extends JsonResource {
    public function toArray($request): array {
        return [
            'id' => $this->id,
            'address' => $this->address,
            'street' => $this->street,
            'city' => $this->city,
            'area' => $this->area,
            'loyalty_points' => $this->loyalty_points,  
        ];
    }
}
