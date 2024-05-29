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
    /**
     * @OA\Post(
     *     path="/api/v1/person",
     *     summary="Add a new person",
     *     tags={"Person"},
     *     @OA\RequestBody(
     *         required=true,
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Person added successfully",
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function addPerson(CreatePersonRequest $request): JsonResponse
    {
        $data = $request->validated();

        $personData = Person::query()->create($data);

        return $this->respondWithSuccess(PersonResource::make($personData));
    }



    /**
     * @OA\Put(
     *     path="/api/v1/person/{person}",
     *     summary="Update an existing person",
     *     tags={"Person"},
     *     @OA\Parameter(
     *         name="person",
     *         in="path",
     *         required=true,
     *        
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *        
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Person updated successfully",
     *        
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Person not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function updatePerson(UpdatePersonRequest $request, Person $person): JsonResponse
    {
        $data = $request->validated();

        $person = Person::find($person->personal_number);

        $person->update($data);

        return $this->respondWithSuccess(PersonResource::make($person));
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/person/{person}",
     *     summary="Remove a person",
     *     tags={"Person"},
     *     @OA\Parameter(
     *         name="person",
     *         in="path",
     *         required=true,
     *        
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Person deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Person not found"
     *     )
     * )
     */
    public function removePerson(Person $person): JsonResponse
    {
        $person->delete();

        return $this->respondWithSuccess(null, __('app.person.deleted'));
    }

    /**
     * @OA\Get(
     *     path="/api/v1/person/{person}",
     *     summary="Get a person by personal number",
     *     tags={"Person"},
     *     @OA\Parameter(
     *         name="person",
     *         in="path",
     *         required=true,
     *       
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Person retrieved successfully",
     *         
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Person not found"
     *     )
     * )
     */
    public function getPerson(Person $person): JsonResponse{

        return $this->respondWithSuccess($person);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/person",
     *     summary="Get all persons",
     *     tags={"Person"},
     *     @OA\Response(
     *         response=200,
     *         description="Persons list retrieved successfully",
     *         
     *     )
     * )
     */
    public function getAllPersons(): JsonResponse{

        return $this->respondWithSuccess(Person::all());
    }

}
