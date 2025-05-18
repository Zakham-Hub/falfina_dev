<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CouponResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
            'from' => $this->from,
            'to' => $this->to,
            'amount' => $this->amount,
            'status' => $this->status,
            'percentage' => $this->percentage,
        ];
    }
}
