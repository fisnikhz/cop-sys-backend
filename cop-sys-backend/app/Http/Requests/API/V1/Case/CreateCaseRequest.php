<?php

namespace App\Http\Requests\API\V1\Case;

use App\Http\Requests\API\APIRequest;

class CreateCaseRequest extends APIRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => 'string',
            'open_date' => 'date',
            'close_date' => 'date',
            'investigator_id' => 'exists:personnels,personnel_id',
            'incidents_id' => 'string'
        ];
    }
}
