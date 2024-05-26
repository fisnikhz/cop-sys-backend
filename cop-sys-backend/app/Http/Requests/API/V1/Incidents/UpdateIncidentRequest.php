<?php

namespace App\Http\Requests\API\V1\Case;

use App\Http\Requests\API\APIRequest;


class UpdateIncidentRequest extends APIRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'incident_type' => 'required|string',
            'description' => 'required|string',
            'report_date_time' => 'timestamp',
            'reporter_id' => 'required|exists:personnels,personnel_id',
        ];
    }
}
