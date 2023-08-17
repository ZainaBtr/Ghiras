<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Percentage extends Model
{
    use HasFactory;
    public $table = "percentages";
    public $primaryKey = "id";
    public $timestamp = true ;

    protected $fillable = [
        'order_win_percent',
        'order_manufacturing_cost',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            $order->percentage_date = Carbon::now(); // تعيين الوقت الحالي للطلب
        });
    }
}
