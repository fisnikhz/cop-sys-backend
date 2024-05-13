<?php

namespace App\Http\Requests\API\V1\Auth;

use App\Http\Requests\API\APIRequest;

class LoginRequest extends APIRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }
}
