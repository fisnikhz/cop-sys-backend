<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class DepartmentPersonnel extends Model
{
    use HasFactory;

    protected $fillable = [
        'conversation_id',
        'personnel_id',
    ];

    public function personnel(): HasOne
    {
        return $this->hasOne(Personnel::class, 'personnel_id','personnel_id');
    }
    public function conversation(): HasOne
    {
        return $this->hasOne(Conversation::class, 'conversation_id','conversation_id');
    }
}
