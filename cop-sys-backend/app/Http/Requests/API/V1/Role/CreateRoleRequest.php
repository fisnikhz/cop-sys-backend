<?php

namespace App\Http\Requests\API\V1\Role;

use App\Http\Requests\API\APIRequest;

class CreateRoleRequest extends APIRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'role_title' => 'required|string',
            'role_description' => 'string',
            
        ];
    }
}
