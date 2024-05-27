<?php

namespace App\Http\Resources\API\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DepartmentPersonnelResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'department_id' => $this->department_id,
            'personnel_id' => $this->personnel_id,
            'personnel' => new PersonnelsResource($this->whenLoaded('personnel')),
            'departments' => new DepartmentsResource($this->whenLoaded('departments')),
        ];
    }
}
