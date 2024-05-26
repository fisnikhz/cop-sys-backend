<?php

namespace App\Http\Requests\API\V1\Auth;

use App\Http\Requests\API\APIRequest;

class ChangePasswordRequest extends APIRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'current_password' => ['required', 'string'],
            'new_password' => ['required', 'string'],
        ];
    }
}
