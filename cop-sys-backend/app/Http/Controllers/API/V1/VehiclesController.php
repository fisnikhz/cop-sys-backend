<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\APIController;
use App\Http\Requests\API\V1\Vehicle\CreateVehicleRequest;
use App\Http\Requests\API\V1\Vehicle\UpdateVehicleRequest;
use App\Http\Resources\API\V1\VehiclesResource;
use App\Models\Vehicle;
use Illuminate\Http\JsonResponse;


class VehiclesController extends APIController
{
    public function addVehicle(CreateVehicleRequest $request): JsonResponse
    {
        $data = $request->validated();

        $vehicleData = Vehicle::query()->create($data);

        return $this->respondWithSuccess(VehiclesResource::make($vehicleData));
    }

    public function updateVehicle(UpdateVehicleRequest $request, Vehicle $vehicle): JsonResponse
    {
        $data = $request->validated();

        $vehicle = Vehicle::find($vehicle->vehicle_id)->firstOrFail();

        $vehicle->update($data);

        return $this->respondWithSuccess(VehiclesResource::make($vehicle));
    }

    public function removeVehicle(Vehicle $vehicle): JsonResponse
    {
        $vehicle->delete();

        return $this->respondWithSuccess(null, __('app.vehicle.deleted'));
    }

    public function getVehicle(Int $vehicle): JsonResponse{

        return $this->respondWithSuccess(Vehicle::find($vehicle)->firstOrFail);
    }
    public function getAllVehicles(): JsonResponse{

        return $this->respondWithSuccess(Vehicle::all());
    }

}
