<?php

namespace App\Models;
use App\Http\Controllers\Meal;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    public $table = "orders";
    public $primaryKey = "id";
    public $timestamp = true ;
    protected $fillable = [
        'order_time',
        'order_state',
        'order_cost',
        'order_discount_percent',
        'order_total_price'
    ];

    protected $hidden = [
        'client_id'
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            $order->order_date = Carbon::now(); // تعيين الوقت الحالي للطلب
        });
    }
    public function meals()
    {
        return $this->belongsToMany(Meal::class)->withPivot('item_quantity', 'item_note', 'item_acceptance');
    }
}
