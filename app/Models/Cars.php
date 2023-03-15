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

    protected $rules =[
        'vin' => 'unique',
        'license_plate'=> 'unique',
        'brand'=> 'unique',
        'model'=> 'unique',
        'gearbox_type'=> 'unique',
        'colour'=> 'unique',
        'fuel_type'=> 'unique',
        'engine_capacity'=> 'unique',
        'power'=> 'unique',
        'engine_code'=> 'unique',
        'car_year'=> 'unique'
    ];
    
}
