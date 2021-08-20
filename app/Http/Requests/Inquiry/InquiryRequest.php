<?php

namespace App\Http\Requests\Inquiry;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;

class InquiryRequest extends FormRequest
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
            'name_'.config('custom.language.default') => 'required',
            // 'slug' => $this->method() == 'POST' ? 'required|max:50|unique:index_urls,slug' : 
            //     'required|max:50|unique:index_urls,slug,'.$this->url_id,
            'slug' => $this->method() == 'POST' ? 'required|unique:index_urls,slug' : 
                'required|unique:index_urls,slug,'.$this->url_id,
            'body_'.config('custom.language.default') => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'name_'.config('custom.language.default') => 'Title',
            'slug' => 'Slug',
            'body_'.config('custom.language.default') => 'Body',
        ];
    }

    public function messages()
    {
        return [
            'name_'.App::getLocale().'.required' => ':attribute is required',
            'slug.required' => ':attribute is required',
            'slug.max' => ':attribute max 50 character',
            'slug.unique' => ':attribute already exists',
            'body_'.App::getLocale().'.required' => ':attribute is required',
        ];
    }
}
