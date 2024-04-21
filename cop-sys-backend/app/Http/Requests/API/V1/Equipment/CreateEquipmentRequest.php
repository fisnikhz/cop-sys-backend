<?php

namespace App\Http\Requests\API\V1\Equipment;

use App\Http\Requests\API\APIRequest;

class CreateEquipmentRequest extends APIRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'quantity' => 'required|int',
            'description' => 'string',
            'location_id' => 'string',
            'location_name' => 'string',
            'longitude' => 'string',
            'latitude' => 'string',
            'radius' => 'int'
        ];
    }
}
