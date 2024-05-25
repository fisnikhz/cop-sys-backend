<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\APIController;
use App\Http\Requests\API\V1\Location\CreateLocationRequest;
use App\Http\Requests\API\V1\Location\UpdateLocationRequest;
use App\Http\Resources\API\V1\LocationResource;
use App\Models\Location;
use Illuminate\Http\JsonResponse;


class LocationController extends APIController
{
    public function addLocation(CreateLocationRequest $request): JsonResponse
    {
        $data = $request->validated();

        $locationData = Location::query()->create($data);

        return $this->respondWithSuccess(LocationResource::make($locationData));
    }

    public function updateLocation(UpdateLocationRequest $request, Location $location): JsonResponse
    {
        $data = $request->validated();

        $location = Location::find($request->location_id);

        $location->update($data);

        return $this->respondWithSuccess(LocationResource::make($location));
    }

    public function removeLocation(Location $location): JsonResponse
    {
        $location->delete();

        return $this->respondWithSuccess(null, __('app.location.deleted'));
    }

    public function getLocation(Int $location): JsonResponse{

        return $this->respondWithSuccess(Location::find($location)->firstOrFail);
    }
    public function getAllLocations(): JsonResponse{

        return $this->respondWithSuccess(Location::all());
    }

}
