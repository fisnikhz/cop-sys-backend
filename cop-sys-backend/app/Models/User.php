<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasUuids;
    protected $primaryKey = 'user_id';

    protected $guarded = [];
    public function personnel():HasOne
    {
        return $this->hasOne(Personnel::class, 'personnel_id','personnel_id');

    }

    public function role():HasOne
    {
        return $this->hasOne(Role::class, 'role_id','role');
    }

    public function conversations()
    {
        return $this->belongsToMany(Conversation::class, 'Conversation_Users', 'sender_id', 'conversation_id');
    }

//    protected $hidden = [
//        'password',
//        'remember_token',
//        'salt'
//    ];
//
//    /**
//     * The attributes that should be cast.
//     *
//     * @var array<string, string>
//     */
//    protected $casts = [
//        'email_verified_at' => 'datetime',
//        'password' => 'hashed',
//    ];
}
