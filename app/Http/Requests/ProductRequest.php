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
            'products.*.name' => 'required|max:255|unique:products',
            'products.*.product_sku' => 'nullable|max:255|unique:products,sku',
            'products.*.height'=>'nullable|numeric|between:0,99999999999.99',
            'products.*.length'=>'nullable|numeric|between:0,99999999999.99',
            'products.*.width'=>'nullable|numeric|between:0,99999999999.99',
            'products.*.size'=>'nullable|numeric|between:0,99999999999.99',
            'products.*.weight'=>'nullable|numeric|between:0,99999999999.99',
            'category_id'=>'required',
            'store_id'=>'required|array',
            'products.*.sku' => 'required|unique:variations,sku,NULL,id,deleted_at,NULL',
            'products.*.product_symbol' => 'nullable|unique:products,product_symbol',

        ];
    }
    public function messages()
    {
        return [
        'name.required'=>__('lang.NameRequired'),
        'name.unique'=>__('lang.NameUnique'),
        'product_sku.unique'=>__('lang.sku_required'),
        'sku.*.unique'=>__('lang.sku_required'),
        'height.numeric'=>__('lang.enter_correct_decimal_number'),
        'length.numeric'=>__('lang.enter_correct_decimal_number'),
        'width.numeric'=>__('lang.enter_correct_decimal_number'),
        'size.numeric'=>__('lang.enter_correct_decimal_number'),
        'weight.numeric'=>__('lang.enter_correct_decimal_number'),
        'category_id.required'=>__('categories.categoryNameRequired'),
        'store_id.required'=>__('lang.required'),
        ];
    }
}
