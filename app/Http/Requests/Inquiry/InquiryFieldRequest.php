<?php

namespace App\Http\Requests\Inquiry;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;

class InquiryFieldRequest extends FormRequest
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

    public function rules()
    {
        return [
            'label_'.config('custom.language.default') => 'required',
            'name' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'label_'.config('custom.language.default') => 'Title',
            'name' => 'Name',
        ];
    }

    public function messages()
    {
        return [
            'label_'.config('custom.language.default').'.required' => ':attribute is required',
            'name.required' => ':attribute is required',
        ];
    }
}
