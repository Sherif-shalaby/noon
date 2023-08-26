<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGeneralTax extends FormRequest
{
    /* +++++++++++++++++ authorize() ++++++++++++++++++ */
    public function authorize()
    {
        return true;
    }
    /* +++++++++++++++++ rules() ++++++++++++++++++ */
    public function rules()
    {
        $id = $this->input('id');
        return [
            'name' => 'required|max:255|unique:general_taxes,name'.$id,
            'rate' => 'required|integer',
            'method' => 'required',
            'store_id' =>'required',
            'details' => 'nullable'
        ];
    }
    /* +++++++++++++++++ messages() ++++++++++++++++++ */
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
