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
     *         @OA\JsonContent(ref="#/components/schemas/CreateCaseRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Case added successfully",
     *         @OA\JsonContent(ref="#/components/schemas/CasesResource")
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
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateCaseRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Case updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/CasesResource")
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

        $case = Cases::find($case->case_id);

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
     *         @OA\Schema(type="integer")
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
     *     summary="View a case by ID",
     *     tags={"Case"},
     *     @OA\Parameter(
     *         name="case",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Case retrieved successfully",
     *         @OA\JsonContent(ref="#/components/schemas/CasesResource")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Case not found"
     *     )
     * )
     */
    public function getCase(Cases $case): JsonResponse{

        return $this->respondWithSuccess($case);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/case",
     *     summary="Get all cases",
     *     tags={"Case"},
     *     @OA\Response(
     *         response=200,
     *         description="Cases list retrieved successfully",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/CasesResource"))
     *     )
     * )
     */
    public function getAllCases(): JsonResponse{

        return $this->respondWithSuccess(Cases::all());
    }

    /**
     * @OA\Get(
     *     path="/api/v1/case/investigator/{personnel_id}",
     *     summary="Get cases by investigator ID",
     *     tags={"Case"},
     *     @OA\Parameter(
     *         name="personnel_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Cases retrieved successfully",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/CasesResource"))
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Cases not found"
     *     )
     * )
     */
    public function getCasesByInvestigator(string $personnel_id): JsonResponse
    {
        $cases = Cases::where('investigator_id', $personnel_id)
            ->get();

        return response()->json(CasesResource::collection($cases), 200);
    }

}
