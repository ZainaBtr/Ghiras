<?php

namespace App\Models;

use App\Http\Controllers\Component_In_MealController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;

class component_in_meal extends Model
{
    use HasFactory;
    public $table = "components_in_meals";
    public $primaryKey = "id";
    public $timestamp = true ;
    protected $fillable = [
        'meal_id',
        'component_id',
        'component_in_meal_quantity',
        'component_in_meal_unit_of_measurement',
    ];

    protected $hidden = [
    ];

//    public function components(){
//        return $this -> hasMany(Component::class);
//    }
    public function meals(){
        return $this -> belongsTo(Meal::class,'meal_id');
    }
    public function component()
    {
        return $this->belongsTo(Component::class, 'component_id');
    }


    public static function convert($value, $fromUnit, $toUnit)
    {
        if ($fromUnit === 'كغ' && $toUnit === 'غ') {
            return $value * 1000;
        } elseif ($fromUnit === 'غ' && $toUnit === 'كغ') {
            return $value / 1000;
        }

        return $value;
    }
}
