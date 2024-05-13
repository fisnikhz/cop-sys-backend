<?php

namespace App\Http\Requests\API\V1\Auth;

use App\Http\Requests\API\APIRequest;

class RegisterRequest extends APIRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'email' => 'required|string',
            'password' => [
                'required',
                'string',
                'min:8',
                function ($attribute, $value, $fail) {
                    if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z0-9]).{8,}$/', $value)) {
                        $fail('The :attribute must contain at least one uppercase letter, one lowercase letter, one number, one special character, and be at least 8 characters long.');
                    }
                },
            ],
            'username' => 'required|string',
            'device_id' => 'required|int',
        ];
    }
}
