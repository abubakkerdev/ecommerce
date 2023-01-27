<?php

namespace App\Http\Requests\Category;

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
        return [
            'cat_name'  => ['required', 'unique:categories'],
            'category_image'  => ['required', 'image', 'file', 'max:3000'],
        ];
    }

    public function messages()
    {
        return [
            'cat_name.unique'   => "This category name  is already have exists.",
        ];
    }
}
