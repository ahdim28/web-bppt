<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'email' => $this->method() == 'POST' ? 'required|email|unique:users,email' : 
                'required|email|unique:users,email,'.$this->id,
            'username' => $this->method() == 'POST' ? 'required|min:5|unique:users,username' : 
                'required|min:5|unique:users,username,'.$this->id,
            // 'phone' => $this->method() == 'POST' ? 'nullable|numeric|unique:users,phone' : 
            //     'nullable|numeric|unique:users,phone,'.$this->id,
            'roles' => 'required',
            'password' => $this->method() == 'POST' ? 'required|confirmed|min:6' : 
                'nullable|confirmed|min:6',
        ];

    }

    public function attributes()
    {
        return [
            'name' => __('mod/users.user.label.field1'),
            'email' => __('mod/users.user.label.field2'),
            'username' => __('mod/users.user.label.field3'),
            'roles' => __('mod/users.user.label.field11'),
            // 'phone' => __('mod/users.user.label.field8'),
            'password' => __('mod/users.user.label.field9'),
        ];
    }
}
