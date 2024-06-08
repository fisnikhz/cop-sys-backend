<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\APIController;
use App\Http\Requests\API\V1\Personnel\CreatePersonnelRequest;
use App\Http\Requests\API\V1\Personnel\UpdatePersonnelRequest;
use App\Http\Resources\API\V1\PersonnelsResource;
use App\Models\Personnel;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PersonnelController extends APIController
{
    /**
     * @OA\Post(
     *     path="/api/v1/personnel",
     *     summary="Add a new personnel",
     *     tags={"Personnel"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/CreatePersonnelRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Personnel added successfully",
     *         @OA\JsonContent(ref="#/components/schemas/PersonnelsResource")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function addPersonnel(CreatePersonnelRequest $request): JsonResponse
    {
        $personnelData = $request->validated();

        // Create personnel record
        $personnel = Personnel::create($personnelData);

        // Set the password as the badge number
        $badgeNumber = $personnel->badge_number;
        $password = $badgeNumber; // Set the password as the badge number

        // Hash the password
        $salt = Str::random(12); // Generate a random salt
        $hashedPassword = Hash::make($password . $salt);

        // Create a user record
        $userData = [
            'name' => $personnel->first_name . ' ' . $personnel->last_name,
            'email' => $request->input('email'), // Assuming you pass email in the request
            'password' => $hashedPassword, // Set the hashed password
            'salt' => $salt, // Store the salt for verification
            'username' => $request->input('username'), // Assuming you pass username in the request
            'device_id' => '', // You may handle this according to your application logic
            'profile_image' => $request->input('profile_image'), // Assuming you pass profile image in the request
            'role' => $request->input('role'), // Assuming you pass role ID in the request
            'personnel_id' => $personnel->personnel_id, // Associate the user with the personnel
        ];

        $user = User::create($userData);

        return $this->respondWithSuccess(PersonnelsResource::make($personnel));
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
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdatePersonnelRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Personnel updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/PersonnelsResource")
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
     *         @OA\Schema(type="string")
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
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Personnel retrieved successfully",
     *         @OA\JsonContent(ref="#/components/schemas/PersonnelsResource")
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
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/PersonnelsResource")
     *         )
     *     )
     * )
     */
    public function getAllPersonnel(): JsonResponse
    {
        $personnel = Personnel::with('role')->get();

        return $this->respondWithSuccess($personnel);
    }
}
