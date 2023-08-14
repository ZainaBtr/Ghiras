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

    public function categories(){
        return $this->belongsTo(Category::class,'category_id');
    }
}
