<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Message extends Model
{
    use HasFactory,HasUuids;

    protected $primaryKey = 'message_id';
    public $incrementing = false;
    protected $keyType = 'uuid';

    protected $guarded = [];
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id', 'user_id');
    }

    public function conversations()
    {
        return $this->belongsToMany(Conversation::class, 'Conversation_Message', 'message_id', 'conversation_id');
    }

}
