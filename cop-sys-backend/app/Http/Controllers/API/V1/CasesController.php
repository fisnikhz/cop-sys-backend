<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\APIController;
use App\Http\Requests\API\V1\Case\CreateCaseRequest;
use App\Http\Requests\API\V1\Case\UpdateCaseRequest;
use App\Http\Resources\API\V1\CasesResource;
use App\Models\Cases;
use Illuminate\Http\JsonResponse;


class CasesController extends APIController 
{
    public function addCase(CreateCaseRequest $request): JsonResponse
    {
        $data = $request->validated();

        $caseData = Cases::query()->create($data);

        return $this->respondWithSuccess(CasesResource::make($caseData));
    }

    public function updateCase(UpdateCaseRequest $request, Cases $case): JsonResponse
    {
        $data = $request->validated();

        $case = Cases::find($case->id)->firstOrFail();

        $case->update($data);

        return $this->respondWithSuccess(CasesResource::make($case));
    }

    public function removeCase(Cases $case): JsonResponse
    {
        $case->delete();

        return $this->respondWithSuccess(null, __('app.case.deleted'));
    }

    public function getCase(Int $case): JsonResponse{

        return $this->respondWithSuccess(Cases::find($case)->firstOrFail);
    }

    public function getAllCases(): JsonResponse{

        return $this->respondWithSuccess(Cases::all());
    }



}