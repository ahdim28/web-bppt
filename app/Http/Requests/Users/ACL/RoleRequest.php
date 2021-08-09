<?php

namespace App\Http\Requests\Users\ACL;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
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
            'name' => $this->method() == 'POST' ? 'required|string|unique:roles,name' : 
                'required|string|unique:roles,name,'.$this->id,
        ];
    }

    public function attributes()
    {
        return [
            'name' => __('mod/users.role.label.field1'),
        ];
    }
}
