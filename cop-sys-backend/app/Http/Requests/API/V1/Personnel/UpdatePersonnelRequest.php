<?php

namespace App\Http\Requests\API\V1\Personnel;

use App\Http\Requests\API\APIRequest;

class UpdatePersonnelRequest extends APIRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => 'string',
            'last_name' => 'string',
            'rank' => 'string',
            'badge_number' => 'string',
            'hire_date' => 'date',
            'profile_image' => 'nullable|string',
            'role' => 'required|exists:roles,role_id',
        ];
    }
}
