<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LanguageRequest extends FormRequest
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
            'iso_codes' => $this->method() == 'POST' ? 'required|max:5|unique:languages,iso_codes' : 
                'required|max:5|unique:languages,iso_codes,'.$this->id,
            'country' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'iso_codes' => __('mod/language.label.field1'),
            'country' => __('mod/language.label.field2'),
        ];
    }
}
