<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class component_in_meal extends Model
{
    use HasFactory;
    public $table = "components";
    public $primaryKey = "id";
    public $timestamp = true ;
    protected $fillable = [
        'meal_name',
        'component_id',
        'component_in_meal_quantity',
        'component_in_meal_unit_of_measurement',
    ];

}
