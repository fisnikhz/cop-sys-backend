<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Personnel extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'rank',
        'badge_number',
        'hire_date',
        'profile_image',
        'role',
    ];

    public function role(): HasOne
    {
        return $this->hasOne(Role::class, 'role_id','role');
    }
}
