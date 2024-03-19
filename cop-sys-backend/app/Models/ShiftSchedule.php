<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ShiftSchedule extends Model
{
    use HasFactory,HasUuids;



    protected $fillable = [
        'personnel_id',
        'shift_start_time',
        'shift_end_time'
    ];

    public function personnel(): HasOne
    {
        return $this->hasOne(Personnel::class, 'personnel_id','personnel_id');
    }

}
