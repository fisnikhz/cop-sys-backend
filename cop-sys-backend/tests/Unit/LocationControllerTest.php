<?php

namespace Tests\Unit;

use App\Http\Controllers\API\V1\LocationController;
use App\Http\Requests\API\V1\Location\CreateLocationRequest;
use App\Http\Requests\API\V1\Location\UpdateLocationRequest;
use App\Http\Resources\API\V1\LocationResource;
use App\Models\Location;
use Illuminate\Http\JsonResponse;
use Mockery;
use Tests\TestCase;

class LocationControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->controller = new LocationController();
    }

    /** @test */
    public function it_can_add_location()
    {
        $data = [
            'name' => 'Test Location',
            'address' => 'Test Address',
            'longitude' => '123.456',
            'latitude' => '78.910',
            'radius' => 100,
        ];

        $request = Mockery::mock(CreateLocationRequest::class);
        $request->shouldReceive('validated')->andReturn($data);

        $location = Mockery::mock(Location::class);
        Location::shouldReceive('create')
            ->with($data)
            ->andReturn($location);

        $response = $this->controller->addLocation($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
        $this->assertEquals(
            (new LocationResource($location))->response()->getData(true),
            $response->getData(true)
        );
    }

    /** @test */
    public function it_can_update_location()
    {
        $data = [
            'name' => 'Updated Location',
            'address' => 'Updated Address',
            'longitude' => '123.456',
            'latitude' => '78.910',
            'radius' => 100,
        ];

        $location = Mockery::mock(Location::class);
        $request = Mockery::mock(UpdateLocationRequest::class);
        $request->shouldReceive('validated')->andReturn($data);

        $location->shouldReceive('update')
            ->with($data)
            ->andReturn(true);

        $response = $this->controller->updateLocation($request, $location);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
        $this->assertEquals(
            (new LocationResource($location))->response()->getData(true),
            $response->getData(true)
        );
    }

    /** @test */
    public function it_can_remove_location()
    {
        $location = Mockery::mock(Location::class);
        $location->shouldReceive('delete')
            ->andReturn(true);

        $response = $this->controller->removeLocation($location);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
    }

    /** @test */
    public function it_can_get_location()
    {
        $location = Mockery::mock(Location::class);

        $response = $this->controller->getLocation($location);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
        $this->assertEquals(
            (new LocationResource($location))->response()->getData(true),
            $response->getData(true)
        );
    }

    /** @test */
    public function it_can_get_all_locations()
    {
        $location = Mockery::mock(Location::class);
        Location::shouldReceive('all')
            ->andReturn(collect([$location]));

        $response = $this->controller->getAllLocations();

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
        $this->assertEquals(
            LocationResource::collection(collect([$location]))->response()->getData(true),
            $response->getData(true)
        );
    }
}
