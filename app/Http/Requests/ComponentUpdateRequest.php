<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ComponentUpdateRequest extends FormRequest
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
        $componentId = $this->route('component'); // Assuming the route parameter is named 'component'

        return [
            'component_name' => ['string',
                Rule::unique('components')
                    ->where('component_address', $this->component_address)
                    ->ignore($componentId)
            ],
            'component_type' => ['string'],
            'component_price' => ['numeric', 'gte:0'],
            'component_address' => ['string'],
            'component_minimal_quantity' => ['numeric', 'gte:0'],
            'component_unit_of_measurement' => ['string'],
            'component_appointment_end_date_reminder' => ['numeric', 'gte:0'],
            'component_available_quantity' => ['numeric', 'gte:0'],
        ];
    }
}
