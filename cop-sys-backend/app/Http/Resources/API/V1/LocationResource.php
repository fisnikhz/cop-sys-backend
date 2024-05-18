<?php

namespace App\Http\Resources\API\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LocationResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->location_id,
            'name' => $this->name,
            'address' => $this->address,
            'longitude' => $this->longitude,
            'latitude' => $this->latitude,
            'radius' => $this->radius,
        ];
    }
}
