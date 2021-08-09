<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'username' => 'required|min:5|unique:users,username',
            'password' => 'required|confirmed|min:6',
        ];
    }

    public function attributes()
    {
        return [
            'name' => __('auth.register.label.field1'),
            'email' => __('auth.register.label.field2'),
            'username' => __('auth.register.label.field3'),
            'password' => __('auth.register.label.field4'),
        ];
    }
}
