<?php

namespace App\Http\Requests\API\V1\Ticket;

use App\Http\Requests\API\APIRequest;

class CreateTicketRequest extends APIRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'description' => 'required|string',
            'title' => 'required|string',
            // 'vehicle' => 'required|exists:vehicle,vehicle_id',
            // 'person' => 'required|exists:person,person_id',
        ];
    }
}
