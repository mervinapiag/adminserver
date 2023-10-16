<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SiteSettingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=> $this->id,
            "mission"=> $this->mission,
            "vision"=> $this->vision,
            "policy"=> $this->policy,
            "logo"=> $this->logo,
            "help" => HelpCentreResource::collection($this->help)
        ];
    }
}
