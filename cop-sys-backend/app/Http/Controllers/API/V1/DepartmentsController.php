<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Departments;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Schema(
 *     schema="Department",
 *     title="Department",
 *     description="Department model",
 *     @OA\Property(property="department_id", type="string", format="uuid", example="123e4567-e89b-12d3-a456-426614174000"),
 *     @OA\Property(property="department_name", type="string", example="Engineering"),
 *     @OA\Property(property="department_logo", type="string", example="https://example.com/logo.png"),
 *     @OA\Property(property="description", type="string", example="Responsible for development and maintenance of software systems."),
 *     @OA\Property(property="hq_location", type="string", format="uuid", example="123e4567-e89b-12d3-a456-426614174000")
 * )
 */
class DepartmentsController extends Controller
{
    /**
     * Add a new department.
     *
     * @OA\Post(
     *     path="/api/addDepartment",
     *     summary="Add a new department",
     *     tags={"Departments"},
     *     security={
     *          {"bearerAuth": {}}
     *     },
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="department_name", type="string"),
     *                 @OA\Property(property="department_logo", type="string"),
     *                 @OA\Property(property="description", type="string"),
     *                 @OA\Property(property="hq_location", type="integer", example="1"),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Department added successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Department added successfully"),
     *             @OA\Property(property="department", ref="#/components/schemas/Department")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="errors", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Database error or server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Database error: ...")
     *         )
     *     )
     * )
     */
    public function addDepartment(Request $request) : JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'department_name' => 'required|string',
                'department_logo' => 'required|string',
                'description' => 'required|string',
                'hq_location' => 'required|exists:locations,location_id',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $department = Departments::create($request->all());

            return response()->json(['message' => 'Department added successfully', 'department' => $department], 201);
        }catch (QueryException $e) {
            return response()->json(['message' => 'Database error: ' . $e->getMessage()], 500);
        } catch (QueryException $e) {
            return response()->json(['message' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    } 

    /**
     * Update an existing department.
     *
     * @OA\Put(
     *     path="/api/updateDepartment",
     *     summary="Update an existing department",
     *     tags={"Departments"},
     *     security={
     *          {"bearerAuth": {}}
     *     },
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="department_id", type="string", format="uuid"),
     *                 @OA\Property(property="department_name", type="string"),
     *                 @OA\Property(property="department_logo", type="string"),
     *                 @OA\Property(property="description", type="string"),
     *                 @OA\Property(property="hq_location", type="integer", example="1"),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Department updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Department updated successfully"),
     *             @OA\Property(property="department", ref="#/components/schemas/Department")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="errors", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Database error or server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Database error: ...")
     *         )
     *     )
     * )
     */
    public function updateDepartment(Request $request) : JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'department_id' => 'required|exists:departments,department_id',
                'department_name' => 'required|string',
                'department_logo' => 'required|string',
                'description' => 'required|string',
                'hq_location' => 'required|exists:locations,location_id',
            ]);

            if($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $department = Departments::find($request->department_id);
            $department->update($request->all());

            return response()->json(['message' => 'Department updated successfully', 'department' => $department], 200);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Database error: ' . $e->getMessage()], 500);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Remove a department.
     *
     * @OA\Delete(
     *     path="/api/removeDepartment",
     *     summary="Remove a department",
     *     tags={"Departments"},
     *     security={
     *          {"bearerAuth": {}}
     *     },
     *     @OA\Parameter(
     *         name="department_id",
     *         in="query",
     *         description="ID of the department to remove",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Department removed successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Department removed successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Department not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Department not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="errors", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Database error or server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Database error: ...")
     *         )
     *     )
     * )
     */
    public function removeDepartment(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'department_id' => 'required|string', 
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $department = Departments::where('department_id', $request->department_id)
                ->first();

            if (!$department) {
                return response()->json(['message' => 'Department not found'], 404);
            }

            $department->delete();

            return response()->json(['message' => 'Department removed successfully'], 200);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Database error: ' . $e->getMessage()], 500);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }
}