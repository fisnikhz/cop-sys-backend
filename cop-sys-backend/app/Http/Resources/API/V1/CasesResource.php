<?php

namespace App\Http\Resources\API\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CasesResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'open_date' => $this->open_date,
            'close_date' => $this->close_date,
            'investigator_id' => $this->investigator_id,
            'incidents_id' => $this->incidents_id
        ];
    }
}
