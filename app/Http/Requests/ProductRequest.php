<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'name' => 'required|max:255|unique:products',
            'height'=>'nullable|numeric|between:0,99999999999.99',
            'length'=>'nullable|numeric|between:0,99999999999.99',
            'width'=>'nullable|numeric|between:0,99999999999.99',
            'size'=>'nullable|numeric|between:0,99999999999.99',
            'weight'=>'nullable|numeric|between:0,99999999999.99',
            'category_id'=>'required',
        ];
    }
    public function messages()
    {
        return [
        'name.required'=>__('lang.NameRequired'),
        'name.unique'=>__('lang.NameUnique'),
        'height.numeric'=>__('lang.enter_correct_decimal_number'),
        'length.numeric'=>__('lang.enter_correct_decimal_number'),
        'width.numeric'=>__('lang.enter_correct_decimal_number'),
        'size.numeric'=>__('lang.enter_correct_decimal_number'),
        'weight.numeric'=>__('lang.enter_correct_decimal_number'),
        'category_id.required'=>__('categories.categoryNameRequired'),
        ];
    }
}
