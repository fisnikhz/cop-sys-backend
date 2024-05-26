<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory,HasUuids;

    protected $primaryKey = 'ticket_id';

    public $timestamps = false;


    protected $fillable = [
        'description',
        'title',
        // 'vehicle',
        // 'person',
    ];

    // public function vehicle()
    // {
    //     return $this->hasOne(Vehicle::class, 'vehicle', 'vehicle_id');
    // }

    // public function person()
    // {
    //     return $this->hasOne(Person::class, 'person', 'person_id');
    // }
}
