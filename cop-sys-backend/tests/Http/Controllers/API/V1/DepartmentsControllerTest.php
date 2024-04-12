<?php
namespace Tests\Http\Controllers\API\V1;

use App\Http\Controllers\API\V1\DepartmentsController;
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
        $token =  env('token'); //Add the token key in .env

        $request = new Request([
            'department_name' => 'Test Department',
            'department_logo' => 'department_logo.jpg',
            'description' => 'Test Description',
            'hq_location' => '1',
        ]);
        $request->headers->set('Authorization', 'Bearer ' . $token);

        $response = $this->controller->addDepartment($request);
        $this->assertEquals(201, $response->getStatusCode());

        $responseData = json_decode($response->getContent(), true);
        $this->assertEquals('Department added successfully', $responseData['message']);

        $this->assertNotNull(Departments::where('department_name', 'Test Department')->first());

        // Simulate the request with invalid data
        $request = new Request([
            // Missing 'department_name' field
            'department_logo' => 'department_logo.jpg',
            'description' => 'Test Description',
            'hq_location' => '1',
        ]);

        $response = $this->controller->addDepartment($request);

        $this->assertEquals(422, $response->getStatusCode());

    }
}
