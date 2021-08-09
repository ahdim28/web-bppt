<?php

namespace App\Http\Requests\Master;

use Illuminate\Foundation\Http\FormRequest;

class TemplateRequest extends FormRequest
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
        if ($this->method() == 'POST') {

            return [
                'name' => 'required',
                'module' => 'required',
                'type' => 'required',
                'filename' => 'required',
            ];

        } else {

            return [
                'name' => 'required',
            ];

        }
    }

    public function attributes()
    {
        return [
            'name' => __('mod/master.template.label.field1'),
            'module' => __('mod/master.template.label.field2'),
            'type' => __('mod/master.template.label.field3'),
            'filename' => __('mod/master.template.label.field5'),
        ];
    }
}
