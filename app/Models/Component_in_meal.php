<?php

namespace App\Models;

use App\Http\Controllers\Component_In_MealController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'component_id',
    ];
    public function components(){
        return $this -> hasMany(Component::class);
    }
    public function meals(){
        return $this -> hasMany(Meal::class);
    }
    public function conversion(Component_in_meal $component_in_meal)
    {
        $unit_of_measurement = $component_in_meal->component_in_meal_unit_of_measurement;
        $quantity = $component_in_meal->component_in_meal_quantity;

        $id = $component_in_meal->component_id;
        $component_row = Component::Where('id', $id)->first();

        if($unit_of_measurement == 'kg')
        {
            if($component_row->component_unit_of_measurement == 'g')
            {
                $converted_quantity_in_converted_unit_of_measurement =  ($quantity * 1000) * $component_row->component_price;
                return $converted_quantity_in_converted_unit_of_measurement;
            }
            if($component_row == 'kg')
            {
                return $quantity * $component_row->component_price;
            }
            else
            {
                return response()->json(['message' => 'error, the unit of measurement must be only kg or g'],
                    Response::HTTP_OK);
                // HTTP_OK = 200
            }
        }
        if($unit_of_measurement->component_unit_of_measurement == 'g')
        {
            if($component_row == 'g')
            {
                return $quantity * $component_row->component_price;
            }
            if($component_row == 'kg')
            {
                $converted_quantity_in_converted_unit_of_measurement = ($quantity / 1000) * $component_row->component_price;
                return $converted_quantity_in_converted_unit_of_measurement;
            }
            else
            {
                return response()->json(['message' => 'error, the unit of measurement must be only kg or g'],
                    Response::HTTP_OK);
                // HTTP_OK = 200
            }
        }
        if($unit_of_measurement->component_unit_of_measurement == 'l')
        {
            if($component_row == 'ml')
            {
                $converted_quantity_in_converted_unit_of_measurement = ($quantity * 1000) * $component_row->component_price;
                return $converted_quantity_in_converted_unit_of_measurement;
            }
            if($component_row == 'l')
            {
                return $quantity * $component_row->component_price;
            }
            else
            {
                return response()->json(['message' => 'error, the unit of measurement must be only l or ml'],
                    Response::HTTP_OK);
                // HTTP_OK = 200
            }
        }
        if($unit_of_measurement->component_unit_of_measurement == 'ml')
        {
            if($component_row == 'ml')
            {
                return $quantity * $component_row->component_price;
            }
            if($component_row == 'l')
            {
                $converted_quantity_in_converted_unit_of_measurement = ($quantity / 1000) * $component_row->component_price;
                return $converted_quantity_in_converted_unit_of_measurement;
            }
            else
            {
                return response()->json(['message' => 'error, the unit of measurement must be only l or ml'],
                    Response::HTTP_OK);
                // HTTP_OK = 200
            }
        }
        if($unit_of_measurement->component_unit_of_measurement == 'piece')
        {
            return $quantity * $component_row->component_price;
        }
    }
}
