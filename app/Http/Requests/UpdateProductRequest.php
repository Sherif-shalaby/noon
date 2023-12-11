<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'name' => 'max:255',
            'product_sku' => 'nullable|max:255',
            'height' => 'nullable|numeric|between:0,99999999999.99',
            'length' => 'nullable|numeric|between:0,99999999999.99',
            'width' => 'nullable|numeric|between:0,99999999999.99',
            'size' => 'nullable|numeric|between:0,99999999999.99',
            'weight' => 'nullable|numeric|between:0,99999999999.99',
            'category_id' => 'required',
            'store_id' => 'required|array',
            'products.*.sku' => 'nullable',
            'product_symbol' => 'nullable',
            'products.*.variations.*.sku' => 'nullable|distinct'
        ];
    }
}
