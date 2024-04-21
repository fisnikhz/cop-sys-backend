<?php

namespace App\Http\Requests\API\V1\Equipment;

use Illuminate\Foundation\Http\FormRequest;

class CreateEquipmentRequest extends FormRequest
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
