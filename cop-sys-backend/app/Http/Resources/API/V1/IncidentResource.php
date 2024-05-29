<?php

namespace App\Http\Resources\API\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IncidentResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'incident_id' => $this->incident_id,
            'incident_type' => $this->incident_type,
            'description' => $this->description,
            'location' => $this->location,
            'report_date_time' => $this->report_date_time,
            'reporter_id' => $this->reporter_id,
            'participants_id' => $this->participants_id,
            'vehicles_number' => $this->vehicles_number,
        ];
    }
}
