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

//    public function conversion(Component_in_meal $component_in_meal)
//    {
//        $unit_of_measurement = $component_in_meal->component_in_meal_unit_of_measurement;
//        $quantity = $component_in_meal->component_in_meal_quantity;
//
//        $id = $component_in_meal->component_id;
//
//        $component_row = Component::Where('id', $id)->first();
//
//        if($unit_of_measurement == 'كغ')
//        {
//            if($component_row->component_unit_of_measurement == 'غ')
//            {
//                $converted_quantity_in_converted_unit_of_measurement =  ($quantity * 1000) * $component_row->component_price;
//                return $converted_quantity_in_converted_unit_of_measurement;
//            }
//            if($component_row == 'كغ')
//            {
//                return $quantity * $component_row->component_price;
//            }
//            else
//            {
//                return response()->json(['message' => 'error, the unit of measurement must be only kg or g'],
//                    Response::HTTP_OK);
//                // HTTP_OK = 200
//            }
//        }
//        if($unit_of_measurement->component_unit_of_measurement == 'غ')
//        {
//            if($component_row == 'غ')
//            {
//                return $quantity * $component_row->component_price;
//            }
//            if($component_row == 'كغ')
//            {
//                $converted_quantity_in_converted_unit_of_measurement = ($quantity / 1000) * $component_row->component_price;
//                return $converted_quantity_in_converted_unit_of_measurement;
//            }
//            else
//            {
//                return response()->json(['message' => 'error, the unit of measurement must be only kg or g'],
//                    Response::HTTP_OK);
//                // HTTP_OK = 200
//            }
//        }
//        if($unit_of_measurement->component_unit_of_measurement == 'كيس')
//        {
//            return $quantity * $component_row->component_price;
//        }
//        if($unit_of_measurement->component_unit_of_measurement == 'قطعة')
//        {
//            return $quantity * $component_row->component_price;
//        }
//    }

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
