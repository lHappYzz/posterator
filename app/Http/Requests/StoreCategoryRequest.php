<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
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
            "category_title" => "required|min:3|max:30|unique:categories,title",
            "subcategory_title.*" => "distinct|different:category_title|unique:child_categories,title|nullable|min:3|max:30",
        ];
    }
}
