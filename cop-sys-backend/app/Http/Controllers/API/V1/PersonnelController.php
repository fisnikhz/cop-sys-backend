<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\APIController;
use App\Http\Requests\API\V1\Personnel\CreatePersonnelRequest;
use App\Http\Requests\API\V1\Personnel\UpdatePersonnelRequest;
use App\Http\Resources\API\V1\PersonnelsResource;
use App\Models\Personnel;
use Illuminate\Http\JsonResponse;


class PersonnelController extends APIController
{
       /**
     * @OA\Post(
     *     path="/api/v1/personnel",
     *     summary="Add a new personnel",
     *     tags={"Personnel"},
     *     @OA\RequestBody(
     *         required=true,
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Personnel added successfully",
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function addPersonnel(CreatePersonnelRequest $request): JsonResponse
    {
        $data = $request->validated();

        $personnelData = Personnel::query()->create($data);

        return $this->respondWithSuccess(PersonnelsResource::make($personnelData));
    }

      /**
     * @OA\Put(
     *     path="/api/v1/personnel/{id}",
     *     summary="Update an existing personnel",
     *     tags={"Personnel"},
     *     @OA\Parameter(
     *         name="id",
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
     *         description="Personnel updated successfully",
     *        
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Personnel not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function updatePersonnel(UpdatePersonnelRequest $request, $personnel): JsonResponse
    {
        $data = $request->validated();

        $personnel = Personnel::find($personnel);

        if (!$personnel) {
            return $this->respondWithError(__('app.personnel.not_found'), 404);
        }

        $personnel->update($data);

        return $this->respondWithSuccess(PersonnelsResource::make($personnel));
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/personnel/{id}",
     *     summary="Remove a personnel",
     *     tags={"Personnel"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *        
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Personnel deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Personnel not found"
     *     )
     * )
     */
    public function removePersonnel(Personnel $personnel): JsonResponse
    {
        $personnel->delete();

        return $this->respondWithSuccess(null, __('app.personnel.deleted'));
    }

    /**
     * @OA\Get(
     *     path="/api/v1/personnel/{id}",
     *     summary="Get a personnel by ID",
     *     tags={"Personnel"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *       
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Personnel retrieved successfully",
     *         
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Personnel not found"
     *     )
     * )
     */
    public function getPersonnel(Personnel $personnel): JsonResponse
    {
        $personnel = Personnel::with('role')->findOrFail($personnel->personnel_id);

        return $this->respondWithSuccess($personnel);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/personnel",
     *     summary="Get all personnel",
     *     tags={"Personnel"},
     *     @OA\Response(
     *         response=200,
     *         description="Personnel list retrieved successfully",
     *         
     *     )
     * )
     */
    public function getAllPersonnel(): JsonResponse
    {
        $personnel = Personnel::with('role')->get();

        return $this->respondWithSuccess($personnel);
    }
}
