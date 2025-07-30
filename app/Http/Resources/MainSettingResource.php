<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MainSettingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'address' => $this->address,
            'email' => $this->email,
            'phone' => $this->phone,
            'description' => $this->description,
            'delivery_fees' => $this->delivery_fees,
            'delivery_fee_per_km' => $this->delivery_fee_per_km,
            'delivery_range' => $this->delivery_range,
            'logo' => $this->getMediaUrl('logo'),
            'key' => $this->key,
        ];
    }
}
