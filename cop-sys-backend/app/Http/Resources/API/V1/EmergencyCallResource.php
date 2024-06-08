<?php

namespace App\Http\Resources\API\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmergencyCallResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'call_id' => $this->call_id,
            'caller_name' => $this->caller_name,
            'phone_number' => $this->phone_number,
            'incident_type' => $this->incident_type,
            'location' => $this->location,
            'time' => $this->time,
            'responder' => $this->responder
        ];
    }
}
