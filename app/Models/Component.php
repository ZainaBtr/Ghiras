<?php

namespace App\Models;

use App\Http\Controllers\Component_In_MealController;
use App\Http\Controllers\Meal;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Component extends Model
{
    use HasFactory;
    public $table = "components";
    public $primaryKey = "id";
    public $timestamp = true ;
    protected $fillable = [
        'component_name',
        'component_type',
        'component_price',
        'component_address',
        'component_minimal_quantity',
        'component_added_quantity',
        'component_available_quantity',
        'component_unit_of_measurement',
        'component_appointment_end_date_reminder'
    ];

    public function meals()
    {
        return $this->belongsToMany(Meal::class, 'component_in_meal', 'component_id', 'meal_id')
            ->withPivot('quantity', 'unit_of_measurement');
    }
}
