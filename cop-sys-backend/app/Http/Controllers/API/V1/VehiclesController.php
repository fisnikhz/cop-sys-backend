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
    /**
     * @OA\Post(
     *     path="/api/v1/vehicle",
     *     summary="Add a new vehicle",
     *     tags={"Vehicle"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/CreateVehicleRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Vehicle added successfully",
     *         @OA\JsonContent(ref="#/components/schemas/VehiclesResource")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function addVehicle(CreateVehicleRequest $request): JsonResponse
    {
        $data = $request->validated();

        $vehicleData = Vehicle::query()->create($data);

        return $this->respondWithSuccess(VehiclesResource::make($vehicleData));
    }

    /**
     * @OA\Put(
     *     path="/api/v1/vehicle/{id}",
     *     summary="Update an existing vehicle",
     *     tags={"Vehicle"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateVehicleRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Vehicle updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/VehiclesResource")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Vehicle not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */

    public function updateVehicle(UpdateVehicleRequest $request, Vehicle $vehicle): JsonResponse
    {
        $data = $request->validated();

        $vehicle = Vehicle::find($vehicle->vehicle_id);

        $vehicle->update($data);

        return $this->respondWithSuccess(VehiclesResource::make($vehicle));
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/vehicle/{id}",
     *     summary="Remove a vehicle",
     *     tags={"Vehicle"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Vehicle deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Vehicle not found"
     *     )
     * )
     */

    public function removeVehicle(Vehicle $vehicle): JsonResponse
    {
        $vehicle->delete();

        return $this->respondWithSuccess(null, __('app.vehicle.deleted'));
    }

    /**
     * @OA\Get(
     *     path="/api/v1/vehicle/{id}",
     *     summary="Get a vehicle by ID",
     *     tags={"Vehicle"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Vehicle retrieved successfully",
     *         @OA\JsonContent(ref="#/components/schemas/VehiclesResource")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Vehicle not found"
     *     )
     * )
     */

    public function getVehicle(Vehicle $vehicle): JsonResponse{
        // dd($vehicle);
        // $vehiclee = Vehicle::findOrFail($vehicle->$vehicle_id);

        return $this->respondWithSuccess($vehicle);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/vehicle",
     *     summary="Get all vehicles",
     *     tags={"Vehicle"},
     *     @OA\Response(
     *         response=200,
     *         description="Vehicle list retrieved successfully",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/VehiclesResource"))
     *     )
     * )
     */
    public function getAllVehicles(): JsonResponse{

        return $this->respondWithSuccess(Vehicle::all());
    }

}
