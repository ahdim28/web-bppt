<?php

namespace App\Http\Requests\Page;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;

class PageRequest extends FormRequest
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
            'title_'.config('custom.language.default') => 'required',
            // 'slug' => $this->method() == 'POST' ? 'required|max:50|unique:index_urls,slug' : 
            //     'required|max:50|unique:index_urls,slug,'.$this->url_id,
            'slug' => $this->method() == 'POST' ? 'required|unique:index_urls,slug' : 
                'required|unique:index_urls,slug,'.$this->url_id,
        ];
    }

    public function attributes()
    {
        return [
            'title_'.config('custom.language.default') => 'Title',
            'slug' => 'Slug',
        ];
    }
}
