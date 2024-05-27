<?php

namespace Tests\Unit;

use App\Http\Controllers\API\V1\TicketsController;
use App\Http\Requests\API\V1\Ticket\CreateTicketRequest;
use App\Http\Requests\API\V1\Ticket\UpdateTicketRequest;
use App\Http\Resources\API\V1\TicketsResource;
use App\Models\Ticket;
use Illuminate\Http\JsonResponse;
use Mockery;
use Tests\TestCase;

class TicketsControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->controller = new TicketsController();
    }

    /** @test */
    public function it_can_add_ticket()
    {
        $request = Mockery::mock(CreateTicketRequest::class);
        $request->shouldReceive('validated')->andReturn([
            'title' => 'Ticket Title',
            'description' => 'Ticket Description',
        ]);

        $ticketData = new Ticket([
            'title' => 'Ticket Title',
            'description' => 'Ticket Description',
        ]);

        Ticket::shouldReceive('create')->once()->andReturn($ticketData);

        $response = $this->controller->addTicket($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
        $this->assertEquals(
            (new TicketsResource($ticketData))->response()->getData(true),
            $response->getData(true)
        );
    }
}
