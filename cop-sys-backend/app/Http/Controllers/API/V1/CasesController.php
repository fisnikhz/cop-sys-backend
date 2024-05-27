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
    /**
     * @OA\Post(
     *     path="/api/v1/case",
     *     summary="Add a new case",
     *     tags={"Case"},
     *     @OA\RequestBody(
     *         required=true,
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Case added successfully",
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function addCase(CreateCaseRequest $request): JsonResponse
    {
        $data = $request->validated();

        $caseData = Cases::query()->create($data);

        return $this->respondWithSuccess(CasesResource::make($caseData));
    }

    /**
     * @OA\Put(
     *     path="/api/v1/case/{case}",
     *     summary="Update an existing case",
     *     tags={"Case"},
     *     @OA\Parameter(
     *         name="case",
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
     *         description="Case updated successfully",
     *        
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Case not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */

    public function updateCase(UpdateCaseRequest $request, Cases $case): JsonResponse
    {
        $data = $request->validated();

        $case = Cases::find($case->case_id)->firstOrFail();

        $case->update($data);

        return $this->respondWithSuccess(CasesResource::make($case));
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/case/{case}",
     *     summary="Remove a case",
     *     tags={"Case"},
     *     @OA\Parameter(
     *         name="case",
     *         in="path",
     *         required=true,
     *        
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Case deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Case not found"
     *     )
     * )
     */
    public function removeCase(Cases $case): JsonResponse
    {
        $case->delete();

        return $this->respondWithSuccess(null, __('app.case.deleted'));
    }


    /**
     * @OA\Get(
     *     path="/api/v1/case/{case}",
     *     summary="Get a case by ID",
     *     tags={"Case"},
     *     @OA\Parameter(
     *         name="case",
     *         in="path",
     *         required=true,
     *       
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Case retrieved successfully",
     *         
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Case not found"
     *     )
     * )
     */
    public function getCase(Int $case): JsonResponse{

        return $this->respondWithSuccess(Cases::find($case)->firstOrFail);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/case",
     *     summary="Get all cases",
     *     tags={"Case"},
     *     @OA\Response(
     *         response=200,
     *         description="Cases list retrieved successfully",
     *         
     *     )
     * )
     */
    public function getAllCases(): JsonResponse{

        return $this->respondWithSuccess(Cases::all());
    }



}
