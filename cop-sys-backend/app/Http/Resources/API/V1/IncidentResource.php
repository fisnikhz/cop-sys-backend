<?php

namespace App\Http\Resources\API\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IncidentResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        try {
            return [
                'incident_id' => $this->incident_id,
                'incident_type' => $this->incident_type,
                'incident_cause' => $this->incident_cause,
                'title' => $this->title,
                'description' => $this->description,
                'reported_date' => $this->reported_date,
                'reporter_id' => $this->reporter_id,
            ];
        }catch (\Exception $exception){
            return ["error" => $exception->getMessage()];
        }

    }
}
