<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerUpdateRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'name' => 'required|max:255|unique:customers,id,'.$this->route()->parameter('id'),
        ];
    }

    public function messages()
    {
        return [
        'name.required'=>__('NameRequired'),
        'name.unique'=>__('NameUnique'),
        ];
    }
}
