<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\APIController;
use App\Http\Requests\API\V1\Message\CreateMessageRequest;
use App\Http\Resources\API\V1\MessageResource;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class MessageController extends APIController
{
    /**
     * @OA\Get(
     *     path="/api/v1/conversations/{conversation}/messages",
     *     summary="Get all messages in a conversation",
     *     tags={"Messages"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="conversation",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Messages list retrieved successfully",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/MessageResource"))
     *     )
     * )
     */
    public function index(Conversation $conversation): JsonResponse
    {
        $messages = $conversation->messages()->with('sender')->get();
        return $this->respondWithSuccess(MessageResource::collection($messages));
    }


    /**
     * @OA\Post(
     *     path="/api/v1/conversations/{conversation}/messages",
     *     summary="Store a new message in a conversation",
     *     tags={"Messages"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="conversation",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/CreateMessageRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Message stored successfully",
     *         @OA\JsonContent(ref="#/components/schemas/MessageResource")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function store(CreateMessageRequest $request, Conversation $conversation): JsonResponse
    {
        $message = $conversation->messages()->create([
            'message_id' => (string) \Illuminate\Support\Str::uuid(),
            'sender_id' => Auth::id(),
            'content' => $request->input('content'),
            'type' => 'text'
        ]);

        return $this->respondWithSuccess(new MessageResource($message));
    }
}
