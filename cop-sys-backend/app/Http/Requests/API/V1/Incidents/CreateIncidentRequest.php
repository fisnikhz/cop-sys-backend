<?php

namespace App\Http\Requests\API\V1\Incidents;

use App\Http\Requests\API\APIRequest;

class CreateIncidentRequest extends APIRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'incident_cause' => 'string',
            'incident_type' => 'string',
            'description' => 'string',
            'location' => 'string',
            'reported_date' => 'date',
            'reporter_id' => 'required|exists:personnels,personnel_id',
            'participants_id' => 'string',
            'vehicles_number' => 'string',
        ];
    }
}
