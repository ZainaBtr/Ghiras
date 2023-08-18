<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item_In_Order extends Model
{
    use HasFactory;
    public $table = "items_in_order";
    public $primaryKey = "id";
    public $timestamp = true ;

    protected $fillable = [
        'order_id',
        'meal_id',
        'item_quantity',
        'item_note',
        'item_acceptance',
    ];

}
