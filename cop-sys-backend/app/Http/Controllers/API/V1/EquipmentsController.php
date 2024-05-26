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
    public function addEquipment(CreateEquipmentRequest $request) : JsonResponse
    {
        $data = $request->validated();

        $equipmentData = Equipment::query()->create($data);

        return $this->respondWithSuccess(EquipmentsResource::make($equipmentData));
    }

    public function updateEquipment(UpdateEquipmentRequest $request, Equipment $equipment): JsonResponse
    {
        $data = $request->validated();

        $equipment = Equipment::find($equipment->equipment_id)->firstOrFail();

        $equipment->update($data);

        return $this->respondWithSuccess(EquipmentsResource::make($equipment));
    }

    public function removeEquipment(Equipment $equipment): JsonResponse
    {
        $equipment->delete();

        return $this->respondWithSuccess(null, __('app.equipment.deleted'));
    }

    public function getEquipment(Int $equipment): JsonResponse{

        return $this->respondWithSuccess(Equipment::find($equipment)->firstOrFail);
    }
    public function getAllEquipment(): JsonResponse{

        return $this->respondWithSuccess(Equipment::all());
    }
}
