<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginFrontendRequest extends FormRequest
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
            'username' => 'required|string|min:5
                        |exists:users,username,active,1',
            'password' => 'required|string|min:6',
        ];
    }

    public function attributes()
    {
        return [
            'username' => __('auth.login_frontend.label.field1'),
            'password' => __('auth.login_frontend.label.field2'),
        ];
    }

    public function messages()
    {
        return [
            'username.exists' => __('auth.login_frontend.alert.exists'),
        ];
    }

    public function forms()
    {
        return [
            'username' => $this->username,
            'password' => $this->password,
        ];
    }
}
