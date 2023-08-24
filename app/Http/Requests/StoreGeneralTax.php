<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGeneralTax extends FormRequest
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
            'name' => 'required|max:255|unique:general_taxes',
            'rate' => 'required|integer',
            'method' => 'required',
            'store_id' =>'required',
            'details' => 'nullable'
        ];
    }

    public function messages()
    {
        return [
            'name.required'=>__('lang.taxNameRequired'),
            'name.unique'=>__('lang.taxNameUnique'),
            'method.required'=>__('lang.taxMethodUnique'),
            'rate.required'=>__('lang.taxRateRequired'),
            'rate.integer'=>__('lang.taxRateInteger'),
        ];

    }
}
