<?php

namespace App\Http\Requests\API\V1\Role;

use App\Http\Requests\API\APIRequest;

class UpdateRoleRequest extends APIRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'role_title' => 'string',
            'role_description' => 'string',
        ];
    }
}
