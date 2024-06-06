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
    /**
     * @OA\Post(
     *     path="/api/v1/location",
     *     summary="Add a new location",
     *     tags={"Location"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/CreateLocationRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Location added successfully",
     *         @OA\JsonContent(ref="#/components/schemas/LocationResource")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function addLocation(CreateLocationRequest $request): JsonResponse
    {
        $data = $request->validated();

        $locationData = Location::query()->create($data);

        return $this->respondWithSuccess(LocationResource::make($locationData));
    }

    /**
     * @OA\Put(
     *     path="/api/v1/location/{location}",
     *     summary="Update an existing location",
     *     tags={"Location"},
     *     @OA\Parameter(
     *         name="location",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateLocationRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Location updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/LocationResource")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Location not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */

    public function updateLocation(UpdateLocationRequest $request, Location $location): JsonResponse
    {
        $data = $request->validated();

        $location = Location::find($request->location_id);

        $location->update($data);

        return $this->respondWithSuccess(LocationResource::make($location));
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/location/{location}",
     *     summary="Remove a location",
     *     tags={"Location"},
     *     @OA\Parameter(
     *         name="location",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Location deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Location not found"
     *     )
     * )
     */
    public function removeLocation(Location $location): JsonResponse
    {
        $location->delete();

        return $this->respondWithSuccess(null, __('app.location.deleted'));
    }

    /**
     * @OA\Get(
     *     path="/api/v1/location/{location}",
     *     summary="Get a location by ID",
     *     tags={"Location"},
     *     @OA\Parameter(
     *         name="location",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Location retrieved successfully",
     *         @OA\JsonContent(ref="#/components/schemas/LocationResource")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Location not found"
     *     )
     * )
     */
    public function getLocation(Int $location): JsonResponse{

        return $this->respondWithSuccess(Location::find($location)->firstOrFail);
    }
    /**
     * @OA\Get(
     *     path="/api/v1/location",
     *     summary="Get all locations",
     *     tags={"Location"},
     *     @OA\Response(
     *         response=200,
     *         description="Locations list retrieved successfully",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/LocationResource"))
     *     )
     * )
     */
    public function getAllLocations(): JsonResponse{

        return $this->respondWithSuccess(Location::all());
    }

}
