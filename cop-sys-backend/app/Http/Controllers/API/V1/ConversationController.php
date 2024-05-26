<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\APIController;
use App\Http\Resources\API\V1\ConversationResource;
use App\Models\Conversation;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ConversationController extends APIController
{
    public function getAdminConversation(): JsonResponse
    {
        $adminIds = User::where('role', 1)->pluck('user_id');
        $userId = Auth::id();

        $conversation = Conversation::whereHas('users', function($query) use ($adminIds, $userId) {
            $query->whereIn('user_id', $adminIds)->orWhere('user_id', $userId);
        })->first();

        if (!$conversation) {
            $conversation = Conversation::create([
                'conversation_id' => (string) \Illuminate\Support\Str::uuid(),
                'conversation_name' => 'Chat with Admins',
                'conversation_picture' => 'default_picture.jpg'
            ]);

            $conversation->users()->attach($adminIds);
            $conversation->users()->attach($userId);
        }

        return $this->respondWithSuccess(new ConversationResource($conversation));
    }
}
