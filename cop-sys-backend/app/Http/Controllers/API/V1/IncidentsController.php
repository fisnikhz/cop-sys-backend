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
    public function addIncident(CreateIncidentRequest $request): JsonResponse
    {
        $data = $request->validated();

        $incidentData = Incident::query()->create($data);

        return $this->respondWithSuccess(IncidentResource::make($incidentData));
    }

    public function updateIncident(UpdateIncidentRequest $request, Incident $incident): JsonResponse
    {
        $data = $request->validated();

        $incident = Incident::find($incident->incident_id)->firstOrFail();

        $incident->update($data);

        return $this->respondWithSuccess(IncidentResource::make($incident));
    }

    public function removeIncident(Incident $incident): JsonResponse
    {
        $incident->delete();

        return $this->respondWithSuccess(null, __('app.case.deleted'));
    }

    public function getIncident(Int $incident): JsonResponse{

        return $this->respondWithSuccess(Cases::find($incident)->firstOrFail);
    }

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
