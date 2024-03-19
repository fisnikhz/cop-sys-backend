<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Equipment extends Model
{
    use HasFactory,HasUuids;


    protected $fillable = [
        'name',
        'quantity',
        'description',
        'location_id',
    ];

    public function location(): HasOne
    {
        return $this->hasOne(Location::class, 'location_id', 'location');
    }

}
