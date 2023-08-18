<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ComponentBillUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'component_bill_purchase_quantity' => ['numeric', 'gte:0'],
            'component_bill_purchase_price' => ['numeric', 'gte:0'],
            'component_bill_purchase_date' => ['date'],
            'component_bill_consumption_quantity' => ['numeric', 'gte:0'],
            'component_bill_waste_quantity' => ['numeric', 'gte:0'],
            'component_bill_expiration_date' => [ 'date'],
        ];
    }
}
