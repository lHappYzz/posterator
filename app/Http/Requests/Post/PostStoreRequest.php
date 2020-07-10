<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

require_once 'htmlpurifier-4.13.0/library/HTMLPurifier.auto.php';

class PostStoreRequest extends FormRequest
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
    public function rules(Request $request)
    {
        $request->post_text = cleanHtml($request->post_text ?? '');

        return [
            "post_title" => "required|max:256",
            "post_text" => "required",
        ];
    }
}
