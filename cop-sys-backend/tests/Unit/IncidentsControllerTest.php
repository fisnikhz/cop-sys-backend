<?php

namespace Tests\Unit;

use App\Http\Controllers\API\V1\IncidentsController;
use App\Http\Requests\API\V1\Case\CreateIncidentRequest;
use App\Http\Requests\API\V1\Case\UpdateIncidentRequest;
use App\Http\Resources\API\V1\IncidentResource;
use App\Models\Incident;
use Illuminate\Http\JsonResponse;
use Mockery;
use Tests\TestCase;

class IncidentsControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->controller = new IncidentsController();
    }

    /** @test */
    public function it_can_add_incident()
    {
        $data = [
            'incident_type' => 'Test Incident',
            'description' => 'Test Description',
            'report_date_time' => '2024-01-01 12:00:00',
            'reporter_id' => 1,
        ];

        $request = Mockery::mock(CreateIncidentRequest::class);
        $request->shouldReceive('validated')->andReturn($data);

        $incident = Mockery::mock(Incident::class);
        Incident::shouldReceive('create')
            ->with($data)
            ->andReturn($incident);

        $response = $this->controller->addIncident($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
        $this->assertEquals(
            (new IncidentResource($incident))->response()->getData(true),
            $response->getData(true)
        );
    }

    /** @test */
    public function it_can_update_incident()
    {
        $data = [
            'incident_type' => 'Updated Incident Type',
            'description' => 'Updated Description',
            'report_date_time' => '2024-01-01 12:00:00',
            'reporter_id' => 1,
        ];

        $incident = Mockery::mock(Incident::class);
        $request = Mockery::mock(UpdateIncidentRequest::class);
        $request->shouldReceive('validated')->andReturn($data);

        $incident->shouldReceive('update')
            ->with($data)
            ->andReturn(true);

        $response = $this->controller->updateIncident($request, $incident);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
        $this->assertEquals(
            (new IncidentResource($incident))->response()->getData(true),
            $response->getData(true)
        );
    }

    /** @test */
    public function it_can_remove_incident()
    {
        $incident = Mockery::mock(Incident::class);
        $incident->shouldReceive('delete')
            ->andReturn(true);

        $response = $this->controller->removeIncident($incident);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
    }

    /** @test */
    public function it_can_get_incident()
    {
        $incident = Mockery::mock(Incident::class);

        $response = $this->controller->getIncident($incident);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
        $this->assertEquals(
            (new IncidentResource($incident))->response()->getData(true),
            $response->getData(true)
        );
    }

    /** @test */
    public function it_can_get_all_incidents()
    {
        $incident = Mockery::mock(Incident::class);
        Incident::shouldReceive('all')
            ->andReturn(collect([$incident]));

        $response = $this->controller->getAllIncidents();

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
        $this->assertEquals(
            IncidentResource::collection(collect([$incident]))->response()->getData(true),
            $response->getData(true)
        );
    }
}
