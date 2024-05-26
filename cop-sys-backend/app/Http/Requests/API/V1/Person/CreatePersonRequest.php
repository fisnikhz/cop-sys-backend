<?php

namespace App\Http\Requests\API\V1\Person;

use App\Http\Requests\API\APIRequest;

class CreatePersonRequest extends APIRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'personal_number' => 'required|string',
            'full_name' => 'required|string',
            'picture' => 'string',
            'vehicle'=> 'string'
            
        ];
    }
}
