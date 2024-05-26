<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Incident extends Model
{
    use HasFactory,HasUuids;

    protected $fillable = [
        'incident_type',
        'description',
//        'location',
        'report_date_time',
        'reporter_id',
        'participants_id',
        'vehicles_number'
    ];

//    public function location(): HasOne
//    {
//        return $this->hasOne(Location::class, 'location_id', 'location');
//    }
    public function reporter(): HasOne
    {
        return $this->hasOne(Personnel::class, 'personnel_id', 'reporter_id');
    }
}
