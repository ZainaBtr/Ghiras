<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meel extends Model
{
    use HasFactory;
    public $table = "meels";
    public $primaryKey = "meal_name";
    public $timestamp = true ;
    protected $fillable = [
        'meal_name',
       'category_name',
        'meal_type',
        'meal_ready_quantity',
        'meal_picture',
        'meal_description',
        'meal_In_menu'
    ];
    protected $hidden = [
        'meal_price',
        'meal_ready_quantity',
    ];
}
