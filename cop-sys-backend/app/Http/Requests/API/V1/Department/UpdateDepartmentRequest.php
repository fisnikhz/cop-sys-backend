<?php

namespace App\Http\Requests\API\V1\Department;

use App\Http\Requests\API\APIRequest;

class UpdateDepartmentRequest extends APIRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'department_name' => 'string',
            'department_logo' => 'string',
            'description' => 'string',
//            'hq_location' => 'exists:locations,location_id',
        ];
    }
}

