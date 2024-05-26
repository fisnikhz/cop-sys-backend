<?php

namespace App\Http\Resources\API\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class ConversationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'conversation_id' => $this->conversation_id,
            'conversation_name' => $this->conversation_name,
            'conversation_picture' => $this->conversation_picture,
            'users' => UserResource::collection($this->users)
        ];
    }
}
