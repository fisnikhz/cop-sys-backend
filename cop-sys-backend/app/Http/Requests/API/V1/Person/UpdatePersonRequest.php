<?php

namespace App\Http\Requests\API\V1\Person;

use App\Http\Requests\API\APIRequest;

class UpdatePersonRequest extends APIRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'personal_number' => 'string',
            'full_name' => 'string',
            'picture' => 'string',
            'vehicle'=> 'string',
        ];
    }
}
