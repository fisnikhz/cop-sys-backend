<?php

namespace Tests\Unit;

use App\Http\Controllers\API\V1\RolesController;
use App\Http\Requests\API\V1\Role\CreateRoleRequest;
use App\Http\Resources\API\V1\RolesResource;
use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Mockery;
use Tests\TestCase;

class RolesControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->controller = new RolesController();
    }

    /** @test */
    public function it_can_add_role()
    {
        $request = Mockery::mock(CreateRoleRequest::class);
        $request->shouldReceive('validated')->andReturn([
            'role_title' => 'Admin',
            'role_description' => 'Administrator',
        ]);

        $roleData = new Role([
            'role_title' => 'Admin',
            'role_description' => 'Administrator',
        ]);

        Role::shouldReceive('create')->once()->andReturn($roleData);

        $response = $this->controller->addRole($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
        $this->assertEquals(
            (new RolesResource($roleData))->response()->getData(true),
            $response->getData(true)
        );
    }
}
