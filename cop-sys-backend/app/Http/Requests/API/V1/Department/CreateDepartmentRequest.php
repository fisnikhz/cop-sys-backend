<?php

namespace App\Http\Requests\API\V1\Department;

use App\Http\Requests\API\APIRequest;

class CreateDepartmentRequest extends APIRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'department_name' => 'required|string',
            'department_logo' => 'string',
            'description' => 'required|string',
//            'hq_location' => 'required|exists:locations,location_id',
        ];
    }
}
