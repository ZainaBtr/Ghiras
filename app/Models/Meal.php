<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    use HasFactory;
    public $table = "meals";
    public $primaryKey = "id";
    public $timestamp = true ;
    protected $fillable = [
        'meal_name',
        'category_id',
        'meal_type',
        'meal_picture',
        'meal_description',
        'meal_price',
        'meal_price_show',
        'meal_In_menu'
    ];

    protected $hidden = [
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function components()
    {
        return $this->belongsToMany(Component::class, 'components_in_meals', 'meal_id', 'component_id')
            ->withPivot('component_in_meal_quantity', 'component_in_meal_unit_of_measurement');
    }
    public function orders()
    {
        return $this->belongsToMany(Order::class)->withPivot('item_quantity', 'item_note', 'item_acceptance');
    }
}
