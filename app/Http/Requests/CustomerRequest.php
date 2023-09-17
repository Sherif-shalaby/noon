<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
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
            'name' => 'required|max:255|unique:customers',
            'customer_type_id'=>'required',
            'notes' => 'nullable|max:255',
        ];
    }
    public function messages()
    {
        return [
        'name.required'=>__('lang.NameRequired'),
        'customer_type_id.required'=>__('lang.NameRequired'),
        'name.unique'=>__('lang.NameUnique'),
        'notes.max'=>"Max Number of Characters is 255 characters",
        ];
    }
}
