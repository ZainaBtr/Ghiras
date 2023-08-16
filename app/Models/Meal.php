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
        return $this->belongsToMany(Component::class, 'component_in_meal', 'meal_id', 'component_id')
            ->withPivot('quantity', 'unit_of_measurement');
    }
}
