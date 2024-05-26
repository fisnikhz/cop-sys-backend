<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\APIController;
use App\Http\Requests\API\V1\Person\CreatePersonRequest;
use App\Http\Requests\API\V1\Person\UpdatePersonRequest;
use App\Http\Resources\API\V1\PersonResource;
use App\Models\Person;
use Illuminate\Http\JsonResponse;


class PersonController extends APIController
{
    public function addPerson(CreatePersonRequest $request): JsonResponse
    {
        $data = $request->validated();

        $personData = Person::query()->create($data);

        return $this->respondWithSuccess(PersonResource::make($personData));
    }

    public function updatePerson(UpdatePersonRequest $request, Person $person): JsonResponse
    {
        $data = $request->validated();

        $person = Person::find($person->personal_number)->firstOrFail();

        $person->update($data);

        return $this->respondWithSuccess(PersonResource::make($person));
    }

    public function removePerson(Person $person): JsonResponse
    {
        $person->delete();

        return $this->respondWithSuccess(null, __('app.person.deleted'));
    }

    public function getPerson(Int $person): JsonResponse{

        return $this->respondWithSuccess(Person::find($person)->firstOrFail);
    }
    public function getAllPersons(): JsonResponse{

        return $this->respondWithSuccess(Person::all());
    }

}
