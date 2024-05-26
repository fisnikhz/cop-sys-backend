<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Conversation extends Model
{
    use HasFactory,HasUuids;

    protected $primaryKey = 'conversation_id';
    public $incrementing = false;
    protected $keyType = 'uuid';

    protected $guarded = [];

    public function users()
    {
        return $this->belongsToMany(User::class, 'Conversation_Users', 'conversation_id', 'sender_id');
    }

    public function messages()
    {
        return $this->belongsToMany(Message::class, 'Conversation_Message', 'conversation_id', 'message_id');
    }
}
