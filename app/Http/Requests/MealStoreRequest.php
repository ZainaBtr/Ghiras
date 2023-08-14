<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MealStoreRequest extends FormRequest
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
            'meal_name' => ['required','string',Rule::unique('meals')],
            'category_name' => ['required','string'],
            'meal_type' => ['required','string'],
            'meal_price_show' => ['required','numeric','gte:0'],
            'meal_picture' => ['required','image','mimes:jpeg,png,jpg,gif,svg,webp'],
            'meal_description' => ['required','string'],
            'meal_In_menu' => ['boolean']
        ];
    }
}
