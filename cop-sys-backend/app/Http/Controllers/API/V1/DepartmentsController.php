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
    public function addDepartment(CreateDepartmentRequest $request): JsonResponse
    {
        $data = $request->validated();

        $departmentData = Department::query()->create($data);

        return $this->respondWithSuccess(DepartmentsResource::make($departmentData));
    }

    public function updateDepartment(UpdateDepartmentRequest $request, Department $department) : JsonResponse
    {
        $data = $request->validated();

        $department = Department::find($department->department_id)->firstOrFail();

        $department->update($data);

        return $this->respondWithSuccess(DepartmentsResource::make($department));
    }

    public function removeDepartment(Department $department): JsonResponse
    {
        $department->delete();

        return $this->respondWithSuccess(null, __('app.department.deleted'));
    }

    public function getDepartment(Int $department): JsonResponse{

        return $this->respondWithSuccess(Department::find($department)->firstOrFail);
    }
    public function getAllDepartments(): JsonResponse{

        return $this->respondWithSuccess(Department::all());
    }
}