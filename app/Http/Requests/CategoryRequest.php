<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        switch ($this->method()) {
            case 'POST':
            {
                return [
                    'name' => 'required|max:255|unique:categories',
                    'status' => 'required',
                    'parent_id' => 'nullable',
                    'cover' => 'nullable|mimes:jpg,jpeg,png|max:2000',
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'name' => 'required|max:255|unique:categories,id,'.$this->route()->parameter('id'),
                    'status' => 'required',
                    'parent_id' => 'nullable',
                    'cover' => 'nullable',
                ];
            }
            default: break;
        }
    }

    public function messages()
    {
        return [
        'name.required'=>__('categories.categoryNameRequired'),



        ];
    }
}
