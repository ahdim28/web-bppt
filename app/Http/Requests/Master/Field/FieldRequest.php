<?php

namespace App\Http\Requests\Master\Field;

use Illuminate\Foundation\Http\FormRequest;

class FieldRequest extends FormRequest
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
            'label' => 'required',
            'name' => 'required',
            'type' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'label' => __('mod/master.field.label.field1'),
            'name' => __('mod/master.field.label.field2'),
            'type' => __('mod/master.field.label.field3'),
        ];
    }
}
