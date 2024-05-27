<?php

namespace Tests\Unit;

use App\Http\Controllers\API\V1\DepartmentsController;
use App\Http\Requests\API\V1\Department\CreateDepartmentRequest;
use App\Http\Requests\API\V1\Department\UpdateDepartmentRequest;
use App\Http\Resources\API\V1\DepartmentsResource;
use App\Models\Departments;
use Illuminate\Http\JsonResponse;
use Mockery;
use Tests\TestCase;

class DepartmentsControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->controller = new DepartmentsController();
    }

    /** @test */
    public function it_can_add_department()
    {
        $data = [
            'department_name' => 'IT',
            'department_logo' => 'logo.png',
            'description' => 'Information Technology',
            'hq_location' => '1',
        ];

        $request = Mockery::mock(CreateDepartmentRequest::class);
        $request->shouldReceive('validated')->andReturn($data);

        $existingDepartment = Mockery::mock(Departments::class);
        Departments::shouldReceive('where')
            ->with('department_name', $data['department_name'])
            ->andReturnSelf();
        Departments::shouldReceive('where')
            ->with('hq_location', $data['hq_location'])
            ->andReturnSelf();
        Departments::shouldReceive('first')
            ->andReturn(null);

        Departments::shouldReceive('create')
            ->with($data)
            ->andReturn($existingDepartment);

        $response = $this->controller->addDepartment($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
        $this->assertEquals(
            (new DepartmentsResource($existingDepartment))->response()->getData(true),
            $response->getData(true)
        );
    }

    /** @test */
    public function it_can_update_department()
    {
        $data = [
            'department_name' => 'IT',
            'department_logo' => 'logo.png',
            'description' => 'Information Technology',
            'hq_location' => '1',
        ];

        $department = Mockery::mock(Departments::class);
        $request = Mockery::mock(UpdateDepartmentRequest::class);
        $request->shouldReceive('validated')->andReturn($data);

        Departments::shouldReceive('findOrFail')
            ->with($department->department_id)
            ->andReturn($department);

        $department->shouldReceive('update')
            ->with($data)
            ->andReturn(true);

        $response = $this->controller->updateDepartment($request, $department);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
        $this->assertEquals(
            (new DepartmentsResource($department))->response()->getData(true),
            $response->getData(true)
        );
    }

    /** @test */
    public function it_can_remove_department()
    {
        $department = Mockery::mock(Departments::class);
        $department->shouldReceive('delete')
            ->andReturn(true);

        $response = $this->controller->removeDepartment($department);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
    }

    /** @test */
    public function it_can_get_department()
    {
        $department = Mockery::mock(Departments::class);
        Departments::shouldReceive('findOrFail')
            ->with(1)
            ->andReturn($department);

        $response = $this->controller->getDepartment(1);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
        $this->assertEquals(
            (new DepartmentsResource($department))->response()->getData(true),
            $response->getData(true)
        );
    }

    /** @test */
    public function it_can_get_all_departments()
    {
        $departments = Mockery::mock(Departments::class);
        Departments::shouldReceive('all')
            ->andReturn(collect([$departments]));

        $response = $this->controller->getAllDepartments();

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
        $this->assertEquals(
            DepartmentsResource::collection(collect([$departments]))->response()->getData(true),
            $response->getData(true)
        );
    }
}
