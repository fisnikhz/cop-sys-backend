<?php

namespace App\Http\Resources\API\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PersonResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'personal_number' => $this->personal_number,
            'full_name' => $this->full_name,
            'picture' => $this->picture,
            'vehicle' => $this->vehicle
        ];
    }
}
