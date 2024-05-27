<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;


class Ticket extends Model
{
    use HasFactory, HasUuids;

    protected $primaryKey = 'ticket_id';

    public $timestamps = false;

    protected $fillable = [
        'description',
        'title',
        'price',
        'vehicle',
        'person',
        'assigning_personnel',
    ];


    public function vehicle(): HasOne
    {
        return $this->hasOne(Vehicle::class, 'vehicle','vehicle_id');
    }
    
    public function person(): HasOne
    {
        return $this->hasOne(Person::class, 'person','personal_number');
    }

    public function assigning_personnel(): HasOne
    {
        return $this->hasOne(Personnel::class, 'assigning_personnel','personnel_id');
    }
}
