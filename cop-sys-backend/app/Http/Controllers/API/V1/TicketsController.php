<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\APIController;
use App\Http\Requests\API\V1\Ticket\CreateTicketRequest;
use App\Http\Requests\API\V1\Ticket\UpdateTicketRequest;
use App\Http\Resources\API\V1\TicketsResource;
use App\Models\Ticket;
use Faker\Provider\Person;
use Illuminate\Http\JsonResponse;

class TicketsController extends APIController
{
    public function addTicket(CreateTicketRequest $request): JsonResponse
    {
        $data = $request->validated();

        $ticketData = Ticket::query()->create($data);

        return $this->respondWithSuccess(TicketsResource::make($ticketData));
    }

    public function updateTicket(UpdateTicketRequest $request, Ticket $ticket): JsonResponse
    {
        $data = $request->validated();

        $ticket = Ticket::find($ticket->ticket_id)->firstOrFail();

        $ticket->update($data);

        return $this->respondWithSuccess(TicketsResource::make($ticket));
    }

    public function removeTicket(Ticket $ticket): JsonResponse
    {
        $ticket->delete();

        return $this->respondWithSuccess(null, __('app.ticket.deleted'));
    }

    public function getTicket(Int $ticket): JsonResponse{

        return $this->respondWithSuccess(Ticket::find($ticket)->firstOrFail);
    }
    public function getAllTickets(): JsonResponse{

        return $this->respondWithSuccess(Ticket::all());
    }

    public function getTicketsByPersonnel(string $personnel_id): JsonResponse
    {
        // Get tickets assigned to the given personnel
        $tickets = Ticket::where('assigning_personnel', $personnel_id)
            ->get();

        // Return the collection of tickets
        return response()->json(TicketsResource::collection($tickets), 200);
    }

}