<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\APIController;
use App\Http\Requests\API\V1\Department\CreateDepartmentRequest;
use App\Http\Requests\API\V1\Department\UpdateDepartmentRequest;
use App\Http\Resources\API\V1\DepartmentsResource;
use App\Models\Department;
use Faker\Provider\Person;
use Illuminate\Http\JsonResponse;



class DepartmentsController extends APIController
{
    /**
     * @OA\Post(
     *     path="/api/v1/department",
     *     summary="Add a new department",
     *     tags={"Department"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/CreateDepartmentRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Department added successfully",
     *         @OA\JsonContent(ref="#/components/schemas/DepartmentsResource")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function addDepartment(CreateDepartmentRequest $request): JsonResponse
    {
        $data = $request->validated();

        $departmentData = Department::query()->create($data);

        return $this->respondWithSuccess(DepartmentsResource::make($departmentData));
    }

    /**
     * @OA\Put(
     *     path="/api/v1/department/{department}",
     *     summary="Update an existing department",
     *     tags={"Department"},
     *     @OA\Parameter(
     *         name="department",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateDepartmentRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Department updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/DepartmentsResource")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Department not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function updateDepartment(UpdateDepartmentRequest $request, Department $department) : JsonResponse
    {
        $data = $request->validated();

        $department = Department::find($department->department_id);

        $department->update($data);

        return $this->respondWithSuccess(DepartmentsResource::make($department));
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/department/{department}",
     *     summary="Remove a department",
     *     tags={"Department"},
     *     @OA\Parameter(
     *         name="department",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Department deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Department not found"
     *     )
     * )
     */
    public function removeDepartment(Department $department): JsonResponse
    {
        $department->delete();

        return $this->respondWithSuccess(null, __('app.department.deleted'));
    }
    /**
     * @OA\Get(
     *     path="/api/v1/department/{department}",
     *     summary="Get a department by ID",
     *     tags={"Department"},
     *     @OA\Parameter(
     *         name="department",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Department retrieved successfully",
     *         @OA\JsonContent(ref="#/components/schemas/DepartmentsResource")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Department not found"
     *     )
     * )
     */

    public function getDepartment(Department $department): JsonResponse{

        return $this->respondWithSuccess($department);
    }


    /**
     * @OA\Get(
     *     path="/api/v1/departments",
     *     summary="Get all departments",
     *     tags={"Department"},
     *     @OA\Response(
     *         response=200,
     *         description="Departments list retrieved successfully",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/DepartmentsResource"))
     *     )
     * )
     */

    public function getAllDepartments(): JsonResponse{

        return $this->respondWithSuccess(Department::all());
    }
}
