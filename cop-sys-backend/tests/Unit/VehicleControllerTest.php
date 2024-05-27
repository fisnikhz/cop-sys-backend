<?php

namespace Tests\Unit;

use App\Models\Vehicle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class VehicleControllerTest extends TestCase
{
    use WithFaker;

    /** @test */
    public function it_can_create_a_vehicle()
    {
        $response = $this->postJson('/api/v1/vehicles', [
            'vehicle_registration' => $this->faker->unique()->regexify('[A-Z]{3}[0-9]{3}'),
            'manufacture_name' => $this->faker->company,
            'serie' => $this->faker->word,
            'type' => $this->faker->word,
            'produced_date' => $this->faker->date(),
            'purchased_date' => $this->faker->date(),
            'registration_date' => $this->faker->date(),
            'designated_driver' => 1,
            'car_picture' => $this->faker->imageUrl(),
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('vehicles', $response['data']);
    }

    /** @test */
    public function it_can_update_a_vehicle()
    {
        $vehicle = Vehicle::factory()->create();

        $response = $this->putJson("/api/v1/vehicles/{$vehicle->id}", [
            'vehicle_registration' => $this->faker->unique()->regexify('[A-Z]{3}[0-9]{3}'),
            'manufacture_name' => $this->faker->company,
            'serie' => $this->faker->word,
            'type' => $this->faker->word,
            'produced_date' => $this->faker->date(),
            'purchased_date' => $this->faker->date(),
            'registration_date' => $this->faker->date(),
            'designated_driver' => 1,
            'car_picture' => $this->faker->imageUrl(),
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('vehicles', $response['data']);
    }

    /** @test */
    public function it_can_delete_a_vehicle()
    {
        $vehicle = Vehicle::factory()->create();

        $response = $this->deleteJson("/api/v1/vehicles/{$vehicle->id}");

        $response->assertStatus(200);
        $this->assertDeleted('vehicles', $vehicle->toArray());
    }

    /** @test */
    public function it_can_get_a_vehicle()
    {
        $vehicle = Vehicle::factory()->create();

        $response = $this->getJson("/api/v1/vehicles/{$vehicle->id}");

        $response->assertStatus(200);
        $response->assertJsonFragment($vehicle->toArray());
    }

    /** @test */
    public function it_can_get_all_vehicles()
    {
        $vehicles = Vehicle::factory(5)->create();

        $response = $this->getJson("/api/v1/vehicles");

        $response->assertStatus(200);
        $response->assertJsonCount(5, 'data');
    }
}

