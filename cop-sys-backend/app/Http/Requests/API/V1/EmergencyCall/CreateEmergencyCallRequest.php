<?php

namespace App\Http\Requests\API\V1\EmergencyCall;

use App\Http\Requests\API\APIRequest;

class CreateEmergencyCallRequest extends APIRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'caller_name' => 'string',
            'phone_number' => 'string',
            'incident_type' => 'string',
            'location' => 'exists:locations,location_id',
            'time' => 'date',
            'responder' => 'exists:personnels,personnel_id',
        ];
    }
}
