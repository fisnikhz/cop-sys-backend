<?php

namespace App\Http\Resources\API\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EquipmentsResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'equipment_id' => $this->equipment_id,
            'name' => $this->name,
            'quantity' => $this->quantity,
            'description' => $this->description,
//            'location_id' => $this->location_id,
        ];
    }
}
