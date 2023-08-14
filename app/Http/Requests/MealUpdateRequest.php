<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MealUpdateRequest extends FormRequest
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
            'meal_name' => ['string',Rule::unique('meals')],
            'category_name' => ['string'],
            'meal_type' => ['string'],
            'meal_price_show' => ['numeric','gte:0'],
            'meal_picture' => ['image','mimes:jpeg,png,jpg,gif,svg,webp'],
            'meal_description' => ['string'],
            'meal_In_menu' => ['boolean']
        ];
    }
}
