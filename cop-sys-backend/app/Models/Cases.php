<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Cases extends Model
{
    use HasFactory,HasUuids;

    protected $table = 'cases'; 

    protected $primaryKey = 'case_id'; 

    public $timestamps = false;

    protected $fillable = [
        'status',
        'open_date',
        'close_date',
        'investigator_id',
        'incidents_id'
    ];

    public function investigator_id(): HasOne
    {
        return $this->hasOne(Personnel::class, 'investigator_id','personnel_id');
    }
}
