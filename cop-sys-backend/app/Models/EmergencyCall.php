<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class EmergencyCall extends Model
{
    use HasFactory,HasUuids;


    protected $fillable = [
        'caller_name',
        'phone_number',
        'location',
        'responder',
    ];

    public function location(): HasOne
    {
        return $this->hasOne(Location::class, 'location_id','location');
    }
    public function responder():HasOne{
        return $this->hasOne(Personnel::class, 'personnel_id','responder');
    }


}
