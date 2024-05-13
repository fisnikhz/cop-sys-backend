<?php

namespace App\Http\Requests\API\V1\Vehicle;

use App\Http\Requests\API\APIRequest;

class CreateVehicleRequest extends APIRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'vehicle_registration' => 'required|string',
            'manufacture_name' => 'required|string',
            'serie' => 'required|string',
            'type' => 'required|string',
            'produced_date' => 'required|date',
            'purchased_date' => 'required|date',
            'registration_date' => 'required|date',
            'designated_driver' => 'required|exists:personnels,personnel_id',
            'car_picture' => 'string',
            'car_location' => 'exists:locations,location_id',
        ];
    }
}
