<?php

namespace App\Models;
use App\Http\Controllers\Meal;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Order extends Model
{
    use HasFactory;
    public $table = "orders";
    public $primaryKey = "id";
    public $timestamp = true ;
    protected $fillable = [
        'client_id',
        'order_date',
        'order_time',
        'order_state',
        'order_cost',
        'order_discount_percent',
        'order_total_price',
        'time_order',
        'date_order'
    ];

    protected $hidden = [

    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            $order->time_order = Carbon::now();// تعيين الوقت الحالي للطلب
        });
    }

    public function items()
    {
        return $this->hasMany(Item_In_Order::class);
    }
}
