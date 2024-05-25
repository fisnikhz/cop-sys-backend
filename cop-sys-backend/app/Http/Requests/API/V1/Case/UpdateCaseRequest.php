<?php

namespace App\Http\Requests\API\V1\Case;

use App\Http\Requests\API\APIRequest;


class UpdateCaseRequest extends APIRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => 'required|string',
            'open_date' => 'required|date',
            'close_date' => 'date',
            'investigator_id' => 'string',
            'incidents_id' => 'string'
        ];
    }
}
