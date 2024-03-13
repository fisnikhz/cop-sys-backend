<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Message extends Model
{
    use HasFactory;


    protected $fillable = [
        'sender_id',
        'content',
        'type',
    ];

    public function sender(): HasOne
    {
        return $this->hasOne(User::class, 'user_id','sender_id');
    }


}
