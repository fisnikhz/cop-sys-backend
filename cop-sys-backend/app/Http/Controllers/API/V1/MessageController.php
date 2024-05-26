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
    public function index(Conversation $conversation): JsonResponse
    {
        $messages = $conversation->messages()->with('sender')->get();
        return $this->respondWithSuccess(MessageResource::collection($messages));
    }

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
