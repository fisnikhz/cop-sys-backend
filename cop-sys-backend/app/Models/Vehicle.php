<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Vehicle extends Model
{
    use HasFactory, HasUuids;


    protected $fillable = [
        'vehicle_registration',
        'manufacture_name',
        'serie',
        'produced_date',
        'purchased_date',
        'registration_date',
        'designated_driver',
        'car_picture',
        'car_location',
    ];

    public function location(): HasOne
    {
        return $this->hasOne(Location::class, 'location_id','car_location');
    }


    public function driver(): HasOne
    {
        return $this->hasOne(Personnel::class, 'personnel_id','designated_driver');
    }

}
