<?php
namespace App\Http\Resources\Auth;
use App\Http\Resources\Profile;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request): array {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'type'=>"User",
            'profile' => new Profile\UserProfileResource($this->whenLoaded('profile')),
        ];
    }
}
