<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\APIController;
use App\Http\Requests\API\V1\Case\CreateCaseRequest;
use App\Http\Requests\API\V1\Case\CreateIncidentRequest;
use App\Http\Requests\API\V1\Case\UpdateCaseRequest;
use App\Http\Requests\API\V1\Case\UpdateIncidentRequest;
use App\Http\Resources\API\V1\CasesResource;
use App\Http\Resources\API\V1\IncidentResource;
use App\Models\Cases;
use App\Models\Incident;
use Illuminate\Http\JsonResponse;


class IncidentsController extends APIController
{
    /**
     * @OA\Post(
     *     path="/api/v1/incident",
     *     summary="Add a new incident",
     *     tags={"Incident"},
     *     @OA\RequestBody(
     *         required=true,
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Incident added successfully",
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function addIncident(CreateIncidentRequest $request): JsonResponse
    {
        $data = $request->validated();

        $incidentData = Incident::query()->create($data);

        return $this->respondWithSuccess(IncidentResource::make($incidentData));
    }

    /**
     * @OA\Put(
     *     path="/api/v1/incident/{incident}",
     *     summary="Update an existing incident",
     *     tags={"Incident"},
     *     @OA\Parameter(
     *         name="incident",
     *         in="path",
     *         required=true,
     *        
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *        
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Incident updated successfully",
     *        
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Incident not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function updateIncident(UpdateIncidentRequest $request, Incident $incident): JsonResponse
    {
        $data = $request->validated();

        $incident = Incident::find($incident->incident_id)->firstOrFail();

        $incident->update($data);

        return $this->respondWithSuccess(IncidentResource::make($incident));
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/incident/{incident}",
     *     summary="Remove an incident",
     *     tags={"Incident"},
     *     @OA\Parameter(
     *         name="incident",
     *         in="path",
     *         required=true,
     *        
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Incident deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Incident not found"
     *     )
     * )
     */
    public function removeIncident(Incident $incident): JsonResponse
    {
        $incident->delete();

        return $this->respondWithSuccess(null, __('app.case.deleted'));
    }

    /**
     * @OA\Get(
     *     path="/api/v1/incident/{incident}",
     *     summary="Get an incident by ID",
     *     tags={"Incident"},
     *     @OA\Parameter(
     *         name="incident",
     *         in="path",
     *         required=true,
     *       
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Incident retrieved successfully",
     *         
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Incident not found"
     *     )
     * )
     */
    public function getIncident(Int $incident): JsonResponse{

        return $this->respondWithSuccess(Cases::find($incident)->firstOrFail);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/incident",
     *     summary="Get all incidents",
     *     tags={"Incident"},
     *     @OA\Response(
     *         response=200,
     *         description="Incidents list retrieved successfully",
     *         
     *     )
     * )
     */
    public function getAllIncidents(): JsonResponse{

        return $this->respondWithSuccess(Incident::all());
    }



}
