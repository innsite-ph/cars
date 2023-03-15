<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cars extends Model
{
    use HasFactory;
    protected $table = 'cars';
    protected $fillable =[
        'vin' ,
        'license_plate',
        'brand',
        'model',
        'gearbox_type',
        'colour',
        'fuel_type',
        'engine_capacity',
        'power',
        'engine_code',
        'car_year'
    ];

   
}
