<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PercentageStoreRequest extends FormRequest
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
            'order_win_percent' =>  ['required','numeric','gte:0'],
            'order_manufacturing_cost' => ['required','numeric','gte:0'],
        ];
    }
}
