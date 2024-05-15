<?php

namespace App\Http\Resources\API\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PersonnelsResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->personnel_id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'rank' => $this->rank,
            'badge_number' => $this->badge_number,
            'hire_date' => $this->hire_date,
            'profile_image' => $this->profile_image,
            'role' => $this->role,
        ];
    }
}
