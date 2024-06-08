<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Incident extends Model
{
    use HasFactory,HasUuids;

    protected $primaryKey = 'incident_id';

    public $timestamps = false;

    protected $fillable = [
        'title',
        'incident_type',
        'incident_cause',
        'description',
        'reported_time',
        'reporter_id',
        'participants_id',
        'vehicles_number'
    ];


    // public function assigning_personnel(): HasOne
    // {
    //     return $this->hasOne(Personnel::class, 'reporter_id','personnel_id');
    // }
    public function person(): HasOne
    {
        return $this->hasOne(Person::class, 'personal_number','participants_id');
    }
    public function reporter(): HasOne
    {
        return $this->hasOne(Personnel::class, 'personnel_id','reporter_id');
    }
}
