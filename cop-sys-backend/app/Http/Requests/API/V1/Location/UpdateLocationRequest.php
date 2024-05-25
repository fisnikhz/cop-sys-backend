<?php

namespace App\Http\Requests\API\V1\Location;

use App\Http\Requests\API\APIRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdateLocationRequest extends APIRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'int',
            'address' => 'string',
            'longitude' => 'string',
            'latitude' => 'string',
            'radius' => 'int',
        ];
    }
}
