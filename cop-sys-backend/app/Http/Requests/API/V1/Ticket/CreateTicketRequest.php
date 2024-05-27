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
            'price' => 'required|string',
            'assigning_personnel' => 'required|exists:personnels,personnel_id',
            'vehicle' => 'required|exists:vehicle,vehicle_id',
            'person' => 'required|exists:person,personal_number',
        ];
    }
}
