<?php

namespace App\Http\Requests\API\V1\Equipment;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEquipmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'string',
            'quantity' => 'int',
            'description' => 'string',
            'location_id' => 'string',
            'location_name' => 'string',
            'longitude' => 'string',
            'latitude' => 'string',
            'radius' => 'int'
        ];
    }
}
