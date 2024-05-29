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
            'incident_type' => 'string',
            'description' => 'string',
            'location' => 'string',
            'report_date_time' => 'date',
            'reporter_id' => 'required|exists:personnels,personnel_id',
            'participants_id' => 'string',
            'vehicles_number' => 'string',
        ];
    }
}
