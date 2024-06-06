<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\APIController;
use App\Http\Requests\API\V1\Incidents\CreateIncidentRequest;
use App\Http\Requests\API\V1\Incidents\UpdateIncidentRequest;
use App\Http\Resources\API\V1\IncidentResource;
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
     *         @OA\JsonContent(ref="#/components/schemas/CreateIncidentRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Incident added successfully",
     *         @OA\JsonContent(ref="#/components/schemas/IncidentResource")
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
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateIncidentRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Incident updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/IncidentResource")
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

        $incident = Incident::find($incident->incident_id);

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
     *         @OA\Schema(type="integer")
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

        return $this->respondWithSuccess(null, __('app.incident.deleted'));
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
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Incident retrieved successfully",
     *         @OA\JsonContent(ref="#/components/schemas/IncidentResource")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Incident not found"
     *     )
     * )
     */
    public function getIncident(Incident $incident): JsonResponse{

        return $this->respondWithSuccess($incident);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/incident",
     *     summary="Get all incidents",
     *     tags={"Incident"},
     *     @OA\Response(
     *         response=200,
     *         description="Incidents list retrieved successfully",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/IncidentResource"))
     *     )
     * )
     */
    public function getAllIncidents(): JsonResponse{

        return $this->respondWithSuccess(Incident::all());
    }


    public function getIncidentsByReporter(string $personnel_id): JsonResponse
    {
        $incidents = Incident::where('reporter_id', $personnel_id)
            ->get();

        return response()->json(IncidentResource::collection($incidents), 200);
    }
}
