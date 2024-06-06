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
    /**
     * @OA\Post(
     *     path="/api/v1/ticket",
     *     summary="Add a new ticket",
     *     tags={"Ticket"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/CreateTicketRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Ticket added successfully",
     *         @OA\JsonContent(ref="#/components/schemas/TicketsResource")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */

    public function addTicket(CreateTicketRequest $request): JsonResponse
    {
        $data = $request->validated();

        $ticketData = Ticket::query()->create($data);

        return $this->respondWithSuccess(TicketsResource::make($ticketData));
    }

    /**
     * @OA\Put(
     *     path="/api/v1/ticket/{id}",
     *     summary="Update an existing ticket",
     *     tags={"Ticket"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateTicketRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Ticket updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/TicketsResource")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Ticket not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */

    public function updateTicket(UpdateTicketRequest $request, Ticket $ticket): JsonResponse
    {
        $data = $request->validated();

        $ticket = Ticket::find($ticket->ticket_id);

        $ticket->update($data);

        return $this->respondWithSuccess(TicketsResource::make($ticket));
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/ticket/{id}",
     *     summary="Remove a ticket",
     *     tags={"Ticket"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Ticket deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Ticket not found"
     *     )
     * )
     */

    public function removeTicket(Ticket $ticket): JsonResponse
    {
        $ticket->delete();

        return $this->respondWithSuccess(null, __('app.ticket.deleted'));
    }

    /**
     * @OA\Get(
     *     path="/api/v1/ticket/{id}",
     *     summary="Get a ticket by ID",
     *     tags={"Ticket"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Ticket retrieved successfully",
     *         @OA\JsonContent(ref="#/components/schemas/TicketsResource")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Ticket not found"
     *     )
     * )
     */

    public function getTicket(Ticket $ticket): JsonResponse{

        return $this->respondWithSuccess($ticket);
    }
    /**
     * @OA\Get(
     *     path="/api/v1/ticket",
     *     summary="Get all tickets",
     *     tags={"Ticket"},
     *     @OA\Response(
     *         response=200,
     *         description="Ticket list retrieved successfully",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/TicketsResource")
     *         )
     *     )
     * )
     */
    public function getAllTickets(): JsonResponse{

        return $this->respondWithSuccess(Ticket::all());
    }

  /**
   * @OA\Get(
   *     path="/api/v1/ticket/personnel/{personnel_id}",
   *     summary="Get tickets assigned to a personnel",
   *     tags={"Ticket"},
   *     @OA\Parameter(
   *         name="personnel_id",
   *         in="path",
   *         required=true,
   *     ),
   *     @OA\Response(
   *         response=200,
   *       description="Tickets retrieved successfully",
   *          @OA\JsonContent(
   *              type="array",
   *              @OA\Items(ref="#/components/schemas/TicketsResource")
   *          )
   *      ),
   *      @OA\Response(
   *          response=404,
   *          description="Personnel not found"
   *      )
   *  )
   */
  public function getTicketsByPersonnel(string $personnel_id): JsonResponse
    {
        // Get tickets assigned to the given personnel
        $tickets = Ticket::where('assigned_personnel', $personnel_id)
            ->get();

        // Return the collection of tickets
        return response()->json(TicketsResource::collection($tickets), 200);
    }

}
