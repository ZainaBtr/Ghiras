<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComponentBillInFridge extends Model
{
    use HasFactory;
    public $table="component_bill_in_fridges";
    public $primaryKey = "id";
    public $timestamps=true;
    public $fillable=[
        'component_id',
        'component_bill_purchase_quantity',
        'component_bill_purchase_price',
        'component_bill_purchase_date',
        'component_bill_consumption_quantity',
        'component_bill_waste_quantity',
        'component_bill_available',
        'component_bill_expiration_date'
    ];

    public function components()
    {
        return $this->belongsTo(Component::class,'component_id');
    }
}
