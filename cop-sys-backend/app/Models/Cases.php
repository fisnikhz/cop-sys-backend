<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Cases extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'open_date',
        'close_date',
        'investigator_id',
        'incidents_id'
    ];

    public function investigator(): HasOne
    {
        return $this->hasOne(Personnel::class, 'personnel_id','investigator_id');
    }
}
