<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\APIController;
use App\Http\Resources\API\V1\DepartmentPersonnelResource;
use App\Models\DepartmentPersonnel;
use Faker\Provider\Person;
use Illuminate\Http\JsonResponse;

class DepartmentPersonnelController extends APIController
{
    public function getPersonnelByDepartment(string $department_id): JsonResponse
    {
        $department_id = (int) $department_id;

        // Get personnel associated with the given department
        $personnel = DepartmentPersonnel::where('department_id', $department_id)
            ->with('personnel')
            ->get();

        // Return the collection of personnel
        return response()->json(DepartmentPersonnelResource::collection($personnel), 200);
    }

    public function getDepartmentByPersonnel(string $personnel_id): JsonResponse
    {
        $personnel_id = (int) $personnel_id;

        // Get departments associated with the given personnel
        $departments = DepartmentPersonnel::where('personnel_id', $personnel_id)
            ->with('departments')
            ->get();

        // Return the collection of departments
        return response()->json(DepartmentPersonnelResource::collection($departments), 200);
    }
}