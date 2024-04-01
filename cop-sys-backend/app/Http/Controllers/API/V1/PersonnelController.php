<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Personnel;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Schema(
 *     schema="Personnel",
 *     required={"first_name", "last_name", "rank", "badge_number", "hire_date", "role"},
 *     @OA\Property(property="first_name", type="string"),
 *     @OA\Property(property="last_name", type="string"),
 *     @OA\Property(property="rank", type="string"),
 *     @OA\Property(property="badge_number", type="string"),
 *     @OA\Property(property="hire_date", type="string", format="date"),
 *     @OA\Property(property="profile_image", type="string", nullable=true),
 *     @OA\Property(property="role", type="integer"),
 * )
 */

class PersonnelController extends Controller
{
    /**
     * @OA\Post(
     *      path="/api/v1/addPersonnel",
     *      operationId="addPersonnel",
     *      tags={"Personnel"},
     *      summary="Add a new personnel",
     *      description="Creates a new personnel record with the provided information.",
     *      security={
     *          {"bearerAuth": {}}
     *      },
     *      @OA\RequestBody(
     *          required=true,
     *          description="Personnel data",
     *          @OA\JsonContent(
     *              required={"first_name", "last_name", "rank", "badge_number", "hire_date", "role"},
     *              @OA\Property(property="first_name", type="string", example="John"),
     *              @OA\Property(property="last_name", type="string", example="Doe"),
     *              @OA\Property(property="rank", type="string", example="Sergeant"),
     *              @OA\Property(property="badge_number", type="string", example="12345"),
     *              @OA\Property(property="hire_date", type="string", format="date", example="2022-03-20"),
     *              @OA\Property(property="profile_image", type="string", example="http://example.com/profile.jpg"),
     *              @OA\Property(property="role", type="integer", example="1")
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Personnel added successfully",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Personnel added successfully"),
     *              @OA\Property(property="personnel", ref="#/components/schemas/Personnel")
     *          )
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation error",
     *          @OA\JsonContent(
     *              @OA\Property(property="errors", type="object", example={"first_name": {"The first name field is required."}})
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal server error",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="An error occurred: Database error")
     *          )
     *      )
     * )
     */
    public function addPersonnel(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'rank' => 'required|string',
                'badge_number' => 'required|string',
                'hire_date' => 'required|date',
                'profile_image' => 'nullable|string',
                'role' => 'required|exists:roles,role_id',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $personnel = Personnel::create($request->all());

            return response()->json(['message' => 'Personnel added successfully', 'personnel' => $personnel], 201);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Database error: ' . $e->getMessage()], 500);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/v1/updatePersonnel",
     *     operationId="updatePersonnel",
     *     tags={"Personnel"},
     *     summary="Update personnel details",
     *     description="Updates the details of an existing personnel.",
     *     security={
     *          {"bearerAuth": {}}
     *      },
     *     @OA\RequestBody(
     *         required=true,
     *         description="Personnel details",
     *         @OA\JsonContent(
     *             required={"personnel_id", "first_name", "last_name", "rank", "badge_number", "hire_date", "profile_image", "role"},
     *             @OA\Property(property="personnel_id", type="string", format="uuid"),
     *             @OA\Property(property="first_name", type="string"),
     *             @OA\Property(property="last_name", type="string"),
     *             @OA\Property(property="rank", type="string"),
     *             @OA\Property(property="badge_number", type="string"),
     *             @OA\Property(property="hire_date", type="string", format="date"),
     *             @OA\Property(property="profile_image", type="string", nullable=true),
     *             @OA\Property(property="role", type="integer", format="int64"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Personnel updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Personnel updated successfully"),
     *             @OA\Property(property="personnel", ref="#/components/schemas/Personnel"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="errors", type="object"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Database error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Database error: Something went wrong"),
     *         ),
     *     ),
     * )
     */
    public function updatePersonnel(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'personnel_id' => 'required|exists:personnels,personnel_id',
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'rank' => 'required|string',
                'badge_number' => 'required|string',
                'hire_date' => 'required|date',
                'profile_image' => 'nullable|string',
                'role' => 'required|exists:roles,role_id',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $personnel = Personnel::find($request->personnel_id);
            $personnel->update($request->all());

            return response()->json(['message' => 'Personnel updated successfully', 'personnel' => $personnel], 200);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Database error: ' . $e->getMessage()], 500);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }


    /**
     * @OA\Delete(
     *     path="/api/v1/removePersonnel",
     *     operationId="removePersonnel",
     *     tags={"Personnel"},
     *     summary="Remove personnel",
     *     description="Removes a personnel entry based on first name and last name.",
     *     security={
     *         {"bearerAuth": {}}
     *      },
     *     @OA\RequestBody(
     *         required=true,
     *         description="Personnel details",
     *         @OA\JsonContent(
     *             required={"first_name", "last_name"},
     *             @OA\Property(property="first_name", type="string"),
     *             @OA\Property(property="last_name", type="string"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Personnel removed successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Personnel removed successfully"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Personnel not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Personnel not found"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="errors", type="object"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Database error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Database error: Something went wrong"),
     *         ),
     *     ),
     * )
     */
    public function removePersonnel(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'first_name' => 'required|string',
                'last_name' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $personnel = Personnel::where('first_name', $request->first_name)
                                  ->where('last_name', $request->last_name)
                                  ->first();

            if (!$personnel) {
                return response()->json(['message' => 'Personnel not found'], 404);
            }

            $personnel->delete();

            return response()->json(['message' => 'Personnel removed successfully'], 200);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Database error: ' . $e->getMessage()], 500);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }
}
