<?php

namespace Tests\Unit;

use App\Http\Controllers\API\V1\CasesController;
use App\Http\Requests\API\V1\Case\CreateCaseRequest;
use App\Http\Requests\API\V1\Case\UpdateCaseRequest;
use App\Models\Cases;
use Illuminate\Http\JsonResponse;
use Mockery;
use Tests\TestCase;

class CasesControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->controller = new CasesController();
    }

    /** @test */
    public function it_can_add_case()
    {
        $data = [
            'status' => 'Open',
            'open_date' => '2024-01-01',
            'close_date' => null,
            'investigator_id' => '123',
            'incidents_id' => '456',
        ];

        $request = Mockery::mock(CreateCaseRequest::class);
        $request->shouldReceive('validated')->andReturn($data);

        $case = Mockery::mock(Cases::class);
        $case->shouldReceive('create')->with($data)->andReturn(new Cases($data));
        $this->app->instance(Cases::class, $case);

        $response = $this->controller->addCase($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
    }

    /** @test */
    public function it_can_update_case()
    {
        $data = [
            'status' => 'Closed',
            'open_date' => '2024-01-01',
            'close_date' => '2024-02-01',
            'investigator_id' => '123',
            'incidents_id' => '456',
        ];

        $request = Mockery::mock(UpdateCaseRequest::class);
        $request->shouldReceive('validated')->andReturn($data);

        $case = Mockery::mock(Cases::class);
        $case->shouldReceive('find')->with(1)->andReturnSelf();
        $case->shouldReceive('update')->with($data)->andReturnTrue();
        $this->app->instance(Cases::class, $case);

        $response = $this->controller->updateCase($request, 1);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
    }

    /** @test */
    public function it_can_remove_case()
    {
        $case = Mockery::mock(Cases::class);
        $case->shouldReceive('delete')->andReturnTrue();
        $this->app->instance(Cases::class, $case);

        $response = $this->controller->removeCase($case);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
    }

    /** @test */
    public function it_can_get_case()
    {
        $case = Mockery::mock(Cases::class);
        $case->case_id = 1;
        $case->shouldReceive('find')->with(1)->andReturnSelf();
        $case->shouldReceive('firstOrFail')->andReturnSelf();
        $this->app->instance(Cases::class, $case);

        $response = $this->controller->getCase(1);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
    }

    /** @test */
    public function it_can_list_all_cases()
    {
        $cases = Mockery::mock(Cases::class);
        $cases->shouldReceive('all')->andReturn(collect([]));
        $this->app->instance(Cases::class, $cases);

        $response = $this->controller->getAllCases();

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
    }
}
