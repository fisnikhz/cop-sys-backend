<?php

namespace App\Http\Resources\API\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IncidentResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->incident_id,
            'incident_type' => $this->incident_type,
            'description' => $this->description,
            'report_date_time' => $this->report_date_time,
            'reporter_id' => $this->reporter_id,
        ];
    }
}
