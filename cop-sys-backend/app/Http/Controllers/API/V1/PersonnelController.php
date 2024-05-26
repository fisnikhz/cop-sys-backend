<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\APIController;
use App\Http\Requests\API\V1\Personnel\CreatePersonnelRequest;
use App\Http\Requests\API\V1\Personnel\UpdatePersonnelRequest;
use App\Http\Resources\API\V1\PersonnelsResource;
use App\Models\Personnel;
use Faker\Provider\Person;
use Illuminate\Http\JsonResponse;

class PersonnelController extends APIController
{
    public function addPersonnel(CreatePersonnelRequest $request): JsonResponse
    {
        $data = $request->validated();

        $personnelData = Personnel::query()->create($data);

        return $this->respondWithSuccess(PersonnelsResource::make($personnelData));
    }

    public function updatePersonnel(UpdatePersonnelRequest $request, $personnel): JsonResponse
    {
        $data = $request->validated();

        $personnel = Personnel::find($personnel);

        $personnel->update($data);

        return $this->respondWithSuccess(PersonnelsResource::make($personnel));
    }

    public function removePersonnel(Personnel $personnel): JsonResponse
    {
        $personnel->delete();

        return $this->respondWithSuccess(null, __('app.personnel.deleted'));
    }

    public function getPersonnel(Personnel $personnel): JsonResponse{

        $personnel = Personnel::with('role')->findOrFail($personnel->personnel_id);

        return $this->respondWithSuccess($personnel);
    }
    public function getAllPersonnel(): JsonResponse{

        $personnel = Personnel::with('role')->get();

        return $this->respondWithSuccess($personnel);
    }
}
