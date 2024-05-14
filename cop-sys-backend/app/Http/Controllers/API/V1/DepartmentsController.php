<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\APIController;
use App\Http\Requests\API\V1\Department\CreateDepartmentRequest;
use App\Http\Requests\API\V1\Department\UpdateDepartmentRequest;
use App\Http\Resources\API\V1\DepartmentsResource;
use App\Models\Departments;
use Illuminate\Http\JsonResponse;


class DepartmentsController extends APIController
{
    public function addDepartment(CreateDepartmentRequest $request): JsonResponse
    {
        $data = $request->validated();

        $existingDepartment = Departments::where('department_name', $data['department_name'])
            ->where('hq_location', $data['hq_location'])
            ->first();

        if ($existingDepartment) {
            return $this->respondWithError([], __('app.departments.exists'));
        }

        $departmentData = Departments::query()->create($data);

        return $this->respondWithSuccess(DepartmentsResource::make($departmentData));
    }

    public function updateDepartment(UpdateDepartmentRequest $request) : JsonResponse
    {
        $data = $request->validated();

        $department = Departments::where('department_name', $data['department_name'])
            ->where('hq_location', $data['hq_location'])
            ->firstOrFail();

        $department->update($data);

        return $this->respondWithSuccess(DepartmentsResource::make($department));
    }

    public function removeDepartment(Departments $department): JsonResponse
    {
        $department->delete();

        return $this->respondWithSuccess(null, __('app.department.deleted'));
    }

    public function getDepartment(Int $department): JsonResponse{

        return $this->respondWithSuccess(Departments::find($department)->firstOrFail);
    }
    public function getAllDepartments(): JsonResponse{

        return $this->respondWithSuccess(Departments::all());
    }
}
