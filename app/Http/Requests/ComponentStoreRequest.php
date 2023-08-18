<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ComponentStoreRequest extends FormRequest
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
            'component_name' => ['required','string',
                Rule::unique('components')
                    ->where('component_address', $this->component_address)
            ],
            'component_type' => ['required','string'],
            'component_price' => ['required','numeric','gte:0'],
            'component_address' => ['required','string'],
            'component_minimal_quantity' => ['required','numeric','gte:0'],
            'component_unit_of_measurement' => ['required','string'],
            'component_appointment_end_date_reminder' => ['required','numeric','gte:0'],
            'component_available_quantity' => ['numeric','gte:0'],
        ];
    }
}
