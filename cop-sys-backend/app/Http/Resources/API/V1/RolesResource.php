<?php

namespace App\Http\Resources\API\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RolesResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'role_id' => $this->role_id,
            'role_title' => $this->role_title,
            'role_description' => $this->role_description
        ];
    }
}
