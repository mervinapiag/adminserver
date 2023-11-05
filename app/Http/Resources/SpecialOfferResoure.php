<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SpecialOfferResoure extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "image" => $this->image,
            "description" => $this->description,
            "code" => $this->code,
            "type" => $this->type,
            "shipping_off_value" => $this->shipping_off_value,
            "price_off_value" => $this->price_off_value
        ];
    }
}
