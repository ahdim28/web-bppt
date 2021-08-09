<?php

namespace App\Http\Requests\Content;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;

class CategoryRequest extends FormRequest
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
            'slug' => $this->method() == 'POST' ? 'required|max:50|unique:content_categories,slug' : 
                'required|max:50|unique:content_categories,slug,'.$this->id,
        ];
    }

    public function attributes()
    {
        return [
            'name_'.config('custom.language.default') => 'Name',
            'slug' => 'Slug',
        ];
    }
}
