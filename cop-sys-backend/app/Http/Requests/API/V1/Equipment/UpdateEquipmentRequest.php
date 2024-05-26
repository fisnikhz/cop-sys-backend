<?php

namespace App\Http\Requests\API\V1\Equipment;

use App\Http\Requests\API\APIRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdateEquipmentRequest extends APIRequest
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
//            'location_id' => 'string',
//            'location_name' => 'string',
//            'longitude' => 'string',
//            'latitude' => 'string',
            'radius' => 'int'
        ];
    }
}
