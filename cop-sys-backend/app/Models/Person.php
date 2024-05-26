<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;

    
    protected $primaryKey = 'personal_number'; // Specify the primary key column
    public $timestamps = false;



    protected $fillable = [
        'personal_number',
        'full_name',
        'picture',
        'vehicle',

    ];
}
