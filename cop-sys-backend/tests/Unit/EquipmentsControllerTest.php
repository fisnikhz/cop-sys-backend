<?php

namespace Tests\Unit;

use App\Http\Controllers\API\V1\EquipmentsController;
use App\Http\Requests\API\V1\Equipment\CreateEquipmentRequest;
use App\Http\Requests\API\V1\Equipment\UpdateEquipmentRequest;
use App\Http\Resources\API\V1\EquipmentsResource;
use App\Models\Equipment;
use Illuminate\Http\JsonResponse;
use Mockery;
use Tests\TestCase;

class EquipmentsControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->controller = new EquipmentsController();
    }

    /** @test */
    public function it_can_add_equipment()
    {
        $data = [
            'name' => 'Equipment Name',
            'quantity' => 10,
            'description' => 'Equipment Description',
            'location_id' => 1,
            'location_name' => 'Location Name',
            'longitude' => 123.456,
            'latitude' => 78.910,
            'radius' => 50
        ];

        $request = Mockery::mock(CreateEquipmentRequest::class);
        $request->shouldReceive('validated')->andReturn($data);

        $equipment = Mockery::mock(Equipment::class);
        Equipment::shouldReceive('create')
            ->with($data)
            ->andReturn($equipment);

        $response = $this->controller->addEquipment($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
        $this->assertEquals(
            (new EquipmentsResource($equipment))->response()->getData(true),
            $response->getData(true)
        );
    }

    /** @test */
    public function it_can_update_equipment()
    {
        $data = [
            'name' => 'Updated Equipment Name',
            'quantity' => 5,
        ];

        $equipment = Mockery::mock(Equipment::class);
        $request = Mockery::mock(UpdateEquipmentRequest::class);
        $request->shouldReceive('validated')->andReturn($data);

        $equipment->shouldReceive('update')
            ->with($data)
            ->andReturn(true);

        $response = $this->controller->updateEquipment($request, $equipment);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
        $this->assertEquals(
            (new EquipmentsResource($equipment))->response()->getData(true),
            $response->getData(true)
        );
    }

    /** @test */
    public function it_can_remove_equipment()
    {
        $equipment = Mockery::mock(Equipment::class);
        $equipment->shouldReceive('delete')
            ->andReturn(true);

        $response = $this->controller->removeEquipment($equipment);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
    }

    /** @test */
    public function it_can_get_equipment()
    {
        $equipment = Mockery::mock(Equipment::class);

        $response = $this->controller->getEquipment($equipment);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
        $this->assertEquals(
            (new EquipmentsResource($equipment))->response()->getData(true),
            $response->getData(true)
        );
    }

    /** @test */
    public function it_can_get_all_equipment()
    {
        $equipment = Mockery::mock(Equipment::class);
        Equipment::shouldReceive('all')
            ->andReturn(collect([$equipment]));

        $response = $this->controller->getAllEquipment();

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
        $this->assertEquals(
            EquipmentsResource::collection(collect([$equipment]))->response()->getData(true),
            $response->getData(true)
        );
    }
}
