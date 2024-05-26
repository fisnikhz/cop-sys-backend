<?php

namespace App\Http\Requests\API\V1\Ticket;

use App\Http\Requests\API\APIRequest;

class UpdateTicketRequest extends APIRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'description' => 'string',
            'title' => 'string',
            // 'vehicle' => 'exists:vehicle,vehicle_id',
            // 'person' => 'exists:person,person_id',
        ];
    }
}

