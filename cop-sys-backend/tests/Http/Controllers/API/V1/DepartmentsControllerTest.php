<?php
namespace Tests\Http\Controllers\API\V1;

use App\Http\Controllers\API\V1\DepartmentsController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Framework\TestCase;
use Illuminate\Http\Request;
use App\Models\Departments;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DepartmentsControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $controller;

    protected function setUp(): void
    {
        parent::setUp();
        $app = require __DIR__.'/../../../../../bootstrap/app.php';
        $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

        $this->controller = $app->make(DepartmentsController::class);
    }

    public function testAddDepartment()
    {
        // Set the authorization token
        $token = 'your_authorization_token_here';
        Auth::shouldReceive('guard->check')->andReturn(true);
        Auth::shouldReceive('guard->user')->andReturn(User::factory()->create());
        Auth::shouldReceive('guard->id')->andReturn(1);
        $request = new Request([
            'department_name' => 'Test Department',
            'department_logo' => 'department_logo.jpg',
            'description' => 'Test Description',
            'hq_location' => '1', // Assuming '1' is a valid location ID
        ]);
        $request->headers->set('Authorization', 'Bearer ' . $token);

        // Call the controller method with the authorized request
        $response = $this->controller->addDepartment($request);

        $request = new Request([
            'department_name' => 'Test Department',
            'department_logo' => 'department_logo.jpg',
            'description' => 'Test Description',
            'hq_location' => '1', // Assuming '1' is a valid location ID
        ]);

        $response = $this->controller->addDepartment($request);

        $this->assertEquals(201, $response->getStatusCode());
        $this->assertEquals('Department added successfully', $response->json('message'));

        $this->assertNotNull(Departments::where('department_name', 'Test Department')->first());

        // Simulate the request with invalid data
        $request = new Request([
            // Missing 'department_name' field
            'department_logo' => 'department_logo.jpg',
            'description' => 'Test Description',
            'hq_location' => '1', // Assuming '1' is a valid location ID
        ]);

        $response = $this->controller->addDepartment($request);

        $this->assertEquals(422, $response->getStatusCode());
        $this->assertEquals('The department_name field is required.', $response->json('errors.department_name.0'));
    }
}
