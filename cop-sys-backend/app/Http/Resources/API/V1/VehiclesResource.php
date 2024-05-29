<?php

namespace App\Http\Resources\API\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VehiclesResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'vehicle_id' => $this->vehicle_id,
            'vehicle_registration' => $this->vehicle_registration,
            'manufacture_name' => $this->manufacture_name,
            'serie' => $this->serie,
            'type' => $this->type,
            'produced_date' => $this->produced_date,
            'purchased_date' => $this->purchased_date,
            'registration_date' => $this->registration_date,
            'designated_driver' => $this->designated_driver,
            'car_picture' => $this->car_picture,
            'car_location' => $this->car_location
        ];
    }
}
