<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UnitupdateRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:255|unique:units,id,'.$this->route()->parameter('id'),
            'base_unit_multiplier' => ['nullable', 'numeric']
        ];
    }

    public function messages()
    {
        return [
        'name.required'=>__('units.unitNameRequired'),
        'name.unique'=>__('units.unitNameUnique'),
        'base_unit_multiplier.numeric'=>__('units.base_unit_multiplier_num')


        ];
    }
}
