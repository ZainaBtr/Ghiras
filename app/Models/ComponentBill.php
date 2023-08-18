<?php

namespace App\Models;

use App\Http\Requests\ComponentBillStoreRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ComponentBill extends Model
{
    use HasFactory;
    public $table="component_bills";
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
        'component_bill_expiration_date',
        'component_date_of_transfer_or_hosting'
    ];

    public function components()
    {
        return $this->belongsTo(Component::class,'component_id');
    }

    public function store(ComponentBillStoreRequest $request, Component $component)
    {
        $validated = $request->validate([
            'component_bill_purchase_quantity' => ['required', 'numeric', 'gte:0'],
            'component_bill_purchase_price' => ['required', 'numeric', 'gte:0'],
            'component_bill_purchase_date' => ['required', 'date'],
            'component_bill_consumption_quantity' => ['required', 'numeric', 'gte:0'],
            'component_bill_waste_quantity' => ['required', 'numeric', 'gte:0'],
            'component_bill_expiration_date' => ['required', 'date'],
        ]);

        $component_bill_available = $validated['component_bill_purchase_quantity']
            - $validated['component_bill_consumption_quantity'] - $validated['component_bill_waste_quantity'];

        $componentBill = self::create(array_merge($validated, [
            'component_id' => $component['id'],
            'component_bill_available' => $component_bill_available,
        ]));

        //////////////////////////////////////rest editing in component controller

        $rest = ComponentBill::where('component_id', $component['id'])->sum('component_bill_available');

        $component->update(['component_available_quantity' => $rest]);

        return $componentBill;
    }
}
