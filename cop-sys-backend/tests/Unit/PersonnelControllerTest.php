<?php

namespace Tests\Unit;

use App\Http\Controllers\API\V1\PersonnelController;
use App\Http\Requests\API\V1\Personnel\CreatePersonnelRequest;
use App\Http\Requests\API\V1\Personnel\UpdatePersonnelRequest;
use App\Models\Personnel;
use Illuminate\Http\JsonResponse;
use Mockery;
use Tests\TestCase;

class PersonnelControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->controller = new PersonnelController();
    }

    /** @test */
    public function it_can_add_personnel()
    {
        $data = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'rank' => 'Officer',
            'badge_number' => '12345',
            'hire_date' => '2024-01-01',
            'profile_image' => 'image.jpg',
            'role' => 1,
        ];

        $request = Mockery::mock(CreatePersonnelRequest::class);
        $request->shouldReceive('validated')->andReturn($data);

        $personnel = Mockery::mock(Personnel::class);
        $personnel->shouldReceive('create')->with($data)->andReturn(new Personnel($data));
        $this->app->instance(Personnel::class, $personnel);

        $response = $this->controller->addPersonnel($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
    }

    /** @test */
    public function it_can_update_personnel()
    {
        $data = [
            'first_name' => 'UpdatedName',
            'last_name' => 'Doe',
            'rank' => 'Officer',
            'badge_number' => '12345',
            'hire_date' => '2024-01-01',
            'profile_image' => 'image.jpg',
            'role' => 1,
        ];

        $request = Mockery::mock(UpdatePersonnelRequest::class);
        $request->shouldReceive('validated')->andReturn($data);

        $personnel = Mockery::mock(Personnel::class);
        $personnel->shouldReceive('find')->with(1)->andReturnSelf();
        $personnel->shouldReceive('update')->with($data)->andReturnTrue();
        $this->app->instance(Personnel::class, $personnel);

        $response = $this->controller->updatePersonnel($request, 1);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
    }

    /** @test */
    public function it_can_remove_personnel()
    {
        $personnel = Mockery::mock(Personnel::class);
        $personnel->shouldReceive('delete')->andReturnTrue();
        $this->app->instance(Personnel::class, $personnel);

        // Mock route model binding
        $route = Mockery::mock(\Illuminate\Routing\Route::class);
        $route->shouldReceive('parameter')->with('personnel')->andReturn($personnel);
        $this->app['router']->matched(function ($event) use ($route) {
            $event->route->setParameter('personnel', $route->parameter('personnel'));
        });

        $response = $this->controller->removePersonnel($personnel);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
    }

    /** @test */
    public function it_can_get_personnel()
    {
        $personnel = Mockery::mock(Personnel::class);
        $personnel->personnel_id = "9c255bf2-59df-40ae-a52b-66977a3fefe8";
        $personnel->shouldReceive('with')->with('role')->andReturnSelf();
        $personnel->shouldReceive('find')->with(1)->andReturnSelf();
        $this->app->instance(Personnel::class, $personnel);

        $response = $this->controller->getPersonnel(1);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
    }

    /** @test */
    public function it_can_get_all_personnel()
    {
        $personnel = Mockery::mock(Personnel::class);
        $personnel->shouldReceive('with')->with('role')->andReturnSelf();
        $personnel->shouldReceive('get')->andReturn(collect([]));
        $this->app->instance(Personnel::class, $personnel);

        $response = $this->controller->getAllPersonnel();

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
    }
}
