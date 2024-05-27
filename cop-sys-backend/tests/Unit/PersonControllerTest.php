<?php

namespace Tests\Unit;

use App\Http\Controllers\API\V1\PersonController;
use App\Http\Requests\API\V1\Person\CreatePersonRequest;
use App\Http\Requests\API\V1\Person\UpdatePersonRequest;
use App\Http\Resources\API\V1\PersonResource;
use App\Models\Person;
use Illuminate\Http\JsonResponse;
use Mockery;
use Tests\TestCase;

class PersonControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->controller = new PersonController();
    }

    /** @test */
    public function it_can_add_person()
    {
        $request = Mockery::mock(CreatePersonRequest::class);
        $request->shouldReceive('validated')->andReturn([
            'personal_number' => '1234567890',
            'full_name' => 'John Doe',
            'picture' => 'picture.jpg',
            'vehicle' => 'Car',
        ]);

        $personData = new Person([
            'personal_number' => '1234567890',
            'full_name' => 'John Doe',
            'picture' => 'picture.jpg',
            'vehicle' => 'Car',
        ]);

        Person::shouldReceive('create')->once()->andReturn($personData);

        $response = $this->controller->addPerson($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
        $this->assertEquals(
            (new PersonResource($personData))->response()->getData(true),
            $response->getData(true)
        );
    }
}
