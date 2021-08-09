<?php

namespace App\Http\Requests\Master\Field;

use Illuminate\Foundation\Http\FormRequest;

class FieldCategoryRequest extends FormRequest
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
        ];
    }

    public function attributes()
    {
        return [
            'name' => __('mod/master.field.category.label.field1'),
        ];
    }
}
