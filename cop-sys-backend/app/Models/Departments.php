<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Departments extends Model
{
    use HasFactory;

//$table->uuid('department_id');
//$table->text('department_name');
//$table->text('department_logo');
//$table->text('description');
//$table->uuid('hq_location');
//$table->primary('department_id');
//$table->foreign('hq_location')->references('location_id')->on('Locations');

    protected $fillable = [
        'department_name',
        'department_logo',
        'description',
        'hq_location',
    ];

    public function location(): HasOne
    {
        return $this->hasOne(Location::class, 'location_id','hq_location');
    }

}
