<?php

namespace Tests\Http\Controllers\API\V1;

use App\Http\Controllers\API\V1\EquipmentsController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use PHPUnit\Framework\TestCase;

class EquipmentsControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $controller;

    protected function setUp(): void
    {
        parent::setUp();
        $app = require __DIR__.'/../../../../../bootstrap/app.php';
        $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

        $this->controller = $app->make(EquipmentsController::class);
    }
    public function testAddEquipment()
    {
        $token =  env('token');

        $request = new Request([
            'name' => 'Test Equipment',
            'quantity' => 5,
            'description' => 'Test description',
            'location_id' =>"1"
        ]);

        $request->headers->set('Authorization', 'Bearer ' . $token);

        $response = $this->controller->addEquipment($request);
        $this->assertEquals(200, $response->getStatusCode());


        $request = new Request([
            // Missing 'name' field
            'quantity' => 5,
            'description' => 'Test description',
            'location_id' =>"1"
        ]);

        $response = $this->controller->addEquipment($request);

        $this->assertEquals(422, $response->getStatusCode());

    }
}
