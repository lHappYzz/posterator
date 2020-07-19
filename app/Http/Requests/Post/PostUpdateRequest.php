<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;

require_once 'htmlpurifier-4.13.0/library/HTMLPurifier.auto.php';

class PostUpdateRequest extends FormRequest
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

    public function passedValidation() {
        //remove post text not valid html if request passed the validation
        $this->post_text = cleanHtml($this->post_text);
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'post_title' => 'required|max:190',
            'post_text' => 'required',
            'g-recaptcha-response' => 'required|captcha',
        ];
    }
}
