<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
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
            return [
                "user_name" => ['required', 'string', 'max:60'],
                "user_email" => ['required', 'string', 'email', 'max:254', Rule::unique('users', 'email')->ignore($this->user->id)],
                "role_name" => ['required', 'string', 'exists:roles,name' , 'max:60'],
                "user_password" => ['nullable', 'string', 'min:8'],
            ];
        }
        return [
            "user_name" => ['required', 'string', 'max:60'],
            "user_email" => ['required', 'string', 'email', 'max:254', 'unique:users,email'],
            "role_name" => ['required', 'string', 'exists:roles,name', 'max:60'],
            "user_password" => ['required', 'string', 'min:8'],
        ];
    }
}
