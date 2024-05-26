<?php

namespace App\Http\Requests\API\V1\Vehicle;

use App\Http\Requests\API\APIRequest;

class UpdateVehicleRequest extends APIRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'vehicle_registration' => 'string',
            'manufacture_name' => 'string',
            'serie' => 'string',
            'type' => 'string',
            'produced_date' => 'date',
            'purchased_date' => 'date',
            'registration_date' => 'date',
            'designated_driver' => 'exists:personnels,personnel_id',
            'car_picture' => 'string',
//            'car_location' => 'exists:locations,location_id',
        ];
    }
}
