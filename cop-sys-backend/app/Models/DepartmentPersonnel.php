<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class DepartmentPersonnel extends Model
{
    use HasFactory;

    public $timestamps = false;


    protected $fillable = [
        'department_id',
        'personnel_id',
    ];

    public function personnels(): HasOne
    {
        return $this->hasOne(Personnel::class, 'personnel_id','personnel_id');
    }
    public function departments(): HasOne
    {
        return $this->hasOne(Department::class, 'department_id','department_id');
    }
}
