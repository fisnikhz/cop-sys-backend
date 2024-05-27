<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Department extends Model
{
    use HasFactory,HasUuids;

    protected $primaryKey = 'department_id';

    public $timestamps = false;

    protected $fillable = [
        'department_name',
        'department_logo',
        'description',
//        'hq_location',
    ];

//    public function location(): HasOne
//    {
//        return $this->hasOne(Location::class, 'location_id','hq_location');
//    }

}
