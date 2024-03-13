<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Conversation_Users extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'conversation_id',
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'user_id','user_id');
    }
    public function conversation(): HasOne
    {
        return $this->hasOne(Conversation::class, 'conversation_id','conversation_id');
    }


}
