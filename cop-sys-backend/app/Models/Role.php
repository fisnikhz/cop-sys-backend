<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    
    protected $primaryKey = 'role_id'; // Specify the primary key column
    public $timestamps = false;



    protected $fillable = [
        'role_title',
        'role_description',
    ];
}
