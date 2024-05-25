<?php

namespace App\Http\Requests\API\V1\Location;

use App\Http\Requests\API\APIRequest;

class CreateLocationRequest extends APIRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|int',
            'address' => 'required|string',
            'longitude' => 'required|string',
            'latitude' => 'required|string',
            'radius' => 'required|int',
        ];
    }
}