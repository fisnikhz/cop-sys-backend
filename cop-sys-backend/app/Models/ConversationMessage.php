<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ConversationMessage extends Model
{
    use HasFactory;


    protected $fillable = [
        'conversation_id',
        'message_id',
    ];

    public function message(): HasOne
    {
        return $this->hasOne(Message::class, 'message_id','message_id');
    }
    public function conversation(): HasOne
    {
        return $this->hasOne(Conversation::class, 'conversation_id','conversation_id');
    }
}
