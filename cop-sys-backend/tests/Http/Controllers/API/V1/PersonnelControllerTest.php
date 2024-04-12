<?php

namespace Tests\Http\Controllers\API\V1;

use App\Http\Controllers\API\V1\PersonnelController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class PersonnelControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $controller;
    protected function setUp(): void
    {
        parent::setUp();
        $app = require __DIR__.'/../../../../../bootstrap/app.php';
        $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

        $this->controller = $app->make(PersonnelController::class);
    }

    public function testAddPersonel()
    {
        $token =  env('token');

        $request = new Request([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'rank' => 'Captain',
            'badge_number' => '12345',
            'hire_date' => now(),
            'profile_image' => 'profile.jpg',
            'role' => 1,
        ]);

        $request->headers->set('Authorization', 'Bearer ' . $token);

        $response = $this->controller->addPersonnel($request);

        $this->assertEquals(200, $response->getStatusCode());

        // Simulate the request with missing 'first_name' field
        $request = new Request([
            'last_name' => 'Doe',
            'rank' => 'Captain',
            'badge_number' => '12345',
            'hire_date' => '2022-04-15',
            'profile_image' => 'profile.jpg',
            'role' => 'admin',
        ]);

        $response = $this->controller->addPersonel($request);
        $this->assertEquals(422, $response->getStatusCode());
    }
}
