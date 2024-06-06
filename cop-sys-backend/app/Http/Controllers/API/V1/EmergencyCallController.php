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
    /**
     * @OA\Post(
     *     path="/api/v1/emergency-call",
     *     summary="Add a new emergency call",
     *     tags={"Emergency Calls"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/CreateEmergencyCallRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/EmergencyCallResource")
     *     )
     * )
     */
    public function addEmergencyCall(CreateEmergencyCallRequest $request): JsonResponse
    {
        $data = $request->validated();

        $emergencyCallData = EmergencyCall::query()->create($data);

        return $this->respondWithSuccess(EmergencyCallResource::make($emergencyCallData));
    }

    /**
     * @OA\Put(
     *     path="/api/v1/emergency-call/{emergencyCall}",
     *     summary="Update an existing emergency call",
     *     tags={"Emergency Calls"},
     *     @OA\Parameter(
     *         name="emergencyCall",
     *         in="path",
     *         description="ID of the emergency call",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateEmergencyCallRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/EmergencyCallResource")
     *     )
     * )
     */
    public function updateEmergencyCall(UpdateEmergencyCallRequest $request, EmergencyCall $emergencyCall): JsonResponse
    {
        $data = $request->validated();

        $emergency = EmergencyCall::find($emergencyCall->call_id);

        $emergency->update($data);

        return $this->respondWithSuccess(EmergencyCallResource::make($emergency));
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/emergency-call/{emergencyCall}",
     *     summary="Remove an emergency call",
     *     tags={"Emergency Calls"},
     *     @OA\Parameter(
     *         name="emergencyCall",
     *         in="path",
     *         description="ID of the emergency call",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Emergency call deleted successfully"
     *             )
     *         )
     *     )
     * )
     */
    public function removeEmergencyCall(EmergencyCall $emergencyCall): JsonResponse
    {
        $emergencyCall->delete();

        return $this->respondWithSuccess(null, __('app.emergencyCall.deleted'));
    }

    /**
     * @OA\Get(
     *     path="/api/v1/emergency-call/{emergencyCall}",
     *     summary="Get an emergency call by ID",
     *     tags={"Emergency Calls"},
     *     @OA\Parameter(
     *         name="emergencyCall",
     *         in="path",
     *         description="ID of the emergency call",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/EmergencyCallResource")
     *     )
     * )
     */
    public function getEmergencyCall(EmergencyCall $emergencyCall): JsonResponse{

        return $this->respondWithSuccess($emergencyCall);
    }
    /**
     * @OA\Get(
     *     path="/api/v1/emergency-calls",
     *     summary="Get all emergency calls",
     *     tags={"Emergency Calls"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/EmergencyCallResource")
     *         )
     *     )
     * )
     */
    public function getAllEmergencyCalls(): JsonResponse{

        return $this->respondWithSuccess(EmergencyCall::all());
    }
}
