<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProfileRequest extends FormRequest
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
        if ($this->password != '') {

            return [
                'name' => 'required',
                'email' => 'required|email|unique:users,email,'.Auth::user()->id,
                'username' => 'required|min:5|unique:users,username,'.Auth::user()->id,
                'old_password' => 'required|min:6',
                'password' => 'nullable|confirmed|min:6|different:old_password',
                // 'phone' => 'nullable|numeric|unique:users,phone,'.Auth::user()->id,
            ];

        } else {

            return [
                'name' => 'required|min:5',
                'email' => 'required|email|unique:users,email,'. Auth::user()->id,
                'username' => 'required|unique:users,username,'. Auth::user()->id,
                // 'phone' => 'nullable|numeric|unique:users,phone,'.Auth::user()->id,
            ];
            
        }
    }

    public function attributes()
    {
        return [
            'name' => __('mod/users.user.label.field1'),
            'email' => __('mod/users.user.label.field2'),
            'username' => __('mod/users.user.label.field3'),
            // 'phone' => __('mod/users.user.label.field8'),
            'old_password' =>  __('mod/users.user.label.field9_2'),
            'password' => __('mod/users.user.label.field9'),
        ];
    }
}
