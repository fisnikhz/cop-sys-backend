<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Attendance extends Model
{
    use HasFactory,HasUuids;

//$table->uuid('attendance_id',36);
//$table->uuid('personnel_id',36);
//$table->date('attendance_date');
//$table->datetime('entry_time');
//$table->datetime('exit_time');
//$table->boolean('missed_entry')->default('false');
//$table->foreign('personnel_id')->references('personnel_id')->on('Personnels');

    protected $primaryKey = 'attendance_id';

    public $timestamps = false;

    protected $fillable = [
        'personnel_id',
        'attendance_date',
        'entry_time',
        'exit_time',
        'missed_entry'
    ];

    public function personnel(): HasOne
    {
        return $this->hasOne(Personnel::class, 'personnel_id','personnel_id');
    }



}
