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
            'caller_name' => 'required|string',
            'phone_number' => 'required|string',
            'incident_type' => 'required|string',
//            'location' => 'required|exists:locations,location_id',
            'time' => 'date',
            'responder' => 'required|exists:personnels,personnel_id',
        ];
    }
}
