<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
        if ($this->get('_method') == 'put'){
//            dd($this->all());
            return [
                "category_title" => [Rule::unique('categories', 'title')->ignore($this->category->id), 'required', 'min:3', 'max:30'],
//                "subcategory_title.*.*" => "distinct|different:category_title|nullable|min:3|max:30",
                "subcategory_title.*.*" => ['distinct', 'different:category_title', 'nullable', 'min:3', 'max:30'],
                ];
        }
        return [
            "category_title" => "required|min:3|max:30|unique:categories,title",
            "subcategory_title.*.*" => "distinct|different:category_title|unique:child_categories,title|nullable|min:3|max:30",
        ];
    }

}
