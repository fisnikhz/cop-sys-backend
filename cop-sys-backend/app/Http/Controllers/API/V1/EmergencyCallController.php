<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\APIController;
use App\Http\Requests\API\V1\EmergencyCall\CreateEmergencyCallRequest;
use App\Http\Requests\API\V1\EmergencyCall\UpdateEmergencyCallRequest;
use App\Http\Resources\API\V1\EmergencyCallResource;
use App\Models\EmergencyCall;
use Faker\Provider\Person;
use Illuminate\Http\JsonResponse;

class EmergencyCallController extends APIController
{
    public function addEmergencyCall(CreateEmergencyCallRequest $request): JsonResponse
    {
        $data = $request->validated();

        $emergencyCallData = EmergencyCall::query()->create($data);

        return $this->respondWithSuccess(EmergencyCallResource::make($emergencyCallData));
    }

    public function updateEmergencyCall(UpdateEmergencyCallRequest $request, EmergencyCall $emergencyCall): JsonResponse
    {
        $data = $request->validated();

        $emergencyCall = EmergencyCall::find($request->call_id);

        $emergencyCall->update($data);

        return $this->respondWithSuccess(EmergencyCallResource::make($emergencyCall));
    }

    public function removeEmergencyCall(EmergencyCall $emergencyCall): JsonResponse
    {
        $emergencyCall->delete();

        return $this->respondWithSuccess(null, __('app.emergencyCall.deleted'));
    }

    public function getEmergencyCall(EmergencyCall $emergencyCall): JsonResponse{

        return $this->respondWithSuccess($emergencyCall);
    }
    public function getAllEmergencyCalls(): JsonResponse{

        return $this->respondWithSuccess(EmergencyCall::all());
    }
}
