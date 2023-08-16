<?php

namespace App\Http\Requests;

use App\Models\Meal;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ComponentInMealStoreRequest extends FormRequest
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


    protected $meal;

    public function __construct(Meal $meal)
    {
        $this->meal = $meal;
    }


    public function rules()
    {
//        $meal_id = $this->meal;

        return [
            'component_name' => ['required','string',

            ],
            'component_in_meal_quantity' => ['required','numeric','gte:0'],
            'component_in_meal_unit_of_measurement' => ['required','string']
        ];
    }
}
