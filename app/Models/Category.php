<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $string, mixed $category_name)
 */
class Category extends Model
{
    use HasFactory;
    public $table = "categories";
    protected $primaryKey = "id";
    public $timestamp = true ;
    public $fillable = [
        'category_name'
    ];
    public function meals(){
        return $this -> hasMany(Meal::class);
    }
}
