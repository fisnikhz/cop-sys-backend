<?php

namespace App\Http\Resources\API\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketsResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'ticket_id' => $this->ticket_id,
            'description' => $this->description,
            'title' => $this->title,
            // 'vehicle' => $this->vehicle,
            // 'person' => $this->person
        ];
    }
}
