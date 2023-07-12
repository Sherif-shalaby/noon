<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryupdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
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
            'name' => 'required|max:255|unique:categories,id,'.$this->route()->parameter('id'),
            'status' => 'required',
            'parent_id' => 'nullable',
            'cover' => 'nullable',
        ];
    }

    public function messages()
    {
        return [
        'name.required'=>__('categories.categoryNameRequired'),
        'name.unique'=>__('categories.categoryNameUnique'),



        ];
    }
}
