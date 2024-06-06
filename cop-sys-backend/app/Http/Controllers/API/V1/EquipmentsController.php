<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\APIController;
use App\Http\Requests\API\V1\Equipment\CreateEquipmentRequest;
use App\Http\Requests\API\V1\Equipment\UpdateEquipmentRequest;
use App\Http\Resources\API\V1\EquipmentsResource;
use App\Http\Util\LocationHandler;
use App\Models\Equipment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EquipmentsController extends APIController
{
    /**
     * @OA\Post(
     *     path="/api/v1/equipment",
     *     summary="Add a new equipment",
     *     tags={"Equipment"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/CreateEquipmentRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Equipment added successfully",
     *         @OA\JsonContent(ref="#/components/schemas/EquipmentsResource")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function addEquipment(CreateEquipmentRequest $request) : JsonResponse
    {
        $data = $request->validated();

        $equipmentData = Equipment::query()->create($data);

        return $this->respondWithSuccess(EquipmentsResource::make($equipmentData));
    }

    /**
     * @OA\Put(
     *     path="/api/v1/equipment/{equipment}",
     *     summary="Update an existing equipment",
     *     tags={"Equipment"},
     *     @OA\Parameter(
     *         name="equipment",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateEquipmentRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Equipment updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/EquipmentsResource")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Equipment not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */

    public function updateEquipment(UpdateEquipmentRequest $request, Equipment $equipment): JsonResponse
    {
        $data = $request->validated();

        $equipment = Equipment::find($equipment->equipment_id);

        $equipment->update($data);

        return $this->respondWithSuccess(EquipmentsResource::make($equipment));
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/equipment/{equipment}",
     *     summary="Remove an equipment",
     *     tags={"Equipment"},
     *     @OA\Parameter(
     *         name="equipment",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Equipment deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Equipment not found"
     *     )
     * )
     */
    public function removeEquipment(Equipment $equipment): JsonResponse
    {
        $equipment->delete();

        return $this->respondWithSuccess(null, __('app.equipment.deleted'));
    }


    /**
     * @OA\Get(
     *     path="/api/v1/equipment/{equipment}",
     *     summary="Get an equipment by ID",
     *     tags={"Equipment"},
     *     @OA\Parameter(
     *         name="equipment",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Equipment retrieved successfully",
     *         @OA\JsonContent(ref="#/components/schemas/EquipmentsResource")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Equipment not found"
     *     )
     * )
     */
    public function getEquipment(Equipment $equipment): JsonResponse{

        $equipmentt = Equipment::findOrFail($equipment->equipment_id);

        return $this->respondWithSuccess($equipmentt);
    }


    /**
     * @OA\Get(
     *     path="/api/v1/equipment",
     *     summary="Get all equipment",
     *     tags={"Equipment"},
     *     @OA\Response(
     *         response=200,
     *         description="Equipments list retrieved successfully",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/EquipmentsResource"))
     *     )
     * )
     */

    public function getAllEquipment(): JsonResponse{

        return $this->respondWithSuccess(Equipment::all());
    }
}
