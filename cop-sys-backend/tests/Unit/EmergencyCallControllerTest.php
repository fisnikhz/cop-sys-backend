<?php

namespace Tests\Unit;

use App\Http\Controllers\API\V1\EmergencyCallController;
use App\Http\Requests\API\V1\EmergencyCall\CreateEmergencyCallRequest;
use App\Http\Requests\API\V1\EmergencyCall\UpdateEmergencyCallRequest;
use App\Http\Resources\API\V1\EmergencyCallResource;
use App\Models\EmergencyCall;
use Illuminate\Http\JsonResponse;
use Mockery;
use Tests\TestCase;

class EmergencyCallControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->controller = new EmergencyCallController();
    }

    /** @test */
    public function it_can_add_emergency_call()
    {
        $data = [
            'caller_name' => 'John Doe',
            'phone_number' => '123456789',
            'incident_type' => 'Fire',
            'location' => 1,
            'time' => now()->toDateTimeString(),
            'responder' => 1,
        ];

        $request = Mockery::mock(CreateEmergencyCallRequest::class);
        $request->shouldReceive('validated')->andReturn($data);

        $emergencyCall = Mockery::mock(EmergencyCall::class);
        EmergencyCall::shouldReceive('create')
            ->with($data)
            ->andReturn($emergencyCall);

        $response = $this->controller->addEmergencyCall($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
        $this->assertEquals(
            (new EmergencyCallResource($emergencyCall))->response()->getData(true),
            $response->getData(true)
        );
    }

    /** @test */
    public function it_can_update_emergency_call()
    {
        $data = [
            'caller_name' => 'John Doe Updated',
            'phone_number' => '987654321',
        ];

        $emergencyCall = Mockery::mock(EmergencyCall::class);
        $request = Mockery::mock(UpdateEmergencyCallRequest::class);
        $request->shouldReceive('validated')->andReturn($data);

        $emergencyCall->shouldReceive('update')
            ->with($data)
            ->andReturn(true);

        $response = $this->controller->updateEmergencyCall($request, $emergencyCall);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
        $this->assertEquals(
            (new EmergencyCallResource($emergencyCall))->response()->getData(true),
            $response->getData(true)
        );
    }

    /** @test */
    public function it_can_remove_emergency_call()
    {
        $emergencyCall = Mockery::mock(EmergencyCall::class);
        $emergencyCall->shouldReceive('delete')
            ->andReturn(true);

        $response = $this->controller->removeEmergencyCall($emergencyCall);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
    }

    /** @test */
    public function it_can_get_emergency_call()
    {
        $emergencyCall = Mockery::mock(EmergencyCall::class);

        $response = $this->controller->getEmergencyCall($emergencyCall);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
        $this->assertEquals(
            (new EmergencyCallResource($emergencyCall))->response()->getData(true),
            $response->getData(true)
        );
    }

    /** @test */
    public function it_can_get_all_emergency_calls()
    {
        $emergencyCalls = Mockery::mock(EmergencyCall::class);
        EmergencyCall::shouldReceive('all')
            ->andReturn(collect([$emergencyCalls]));

        $response = $this->controller->getAllEmergencyCalls();

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
        $this->assertEquals(
            EmergencyCallResource::collection(collect([$emergencyCalls]))->response()->getData(true),
            $response->getData(true)
        );
    }
}
