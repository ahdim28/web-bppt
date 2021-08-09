<?php

namespace App\Http\Requests\Content;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;

class PostRequest extends FormRequest
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
            'slug' => $this->method() == 'POST' ? 'required|max:50|unique:content_posts,slug' : 
                'required|max:50|unique:content_posts,slug,'.$this->id,
            'category_id' => 'required',
            'files' => 'nullable|array',
            'files.*' => 'nullable|max:'.config('custom.files.post_files.size').
                '|distinct|mimes:'.config('custom.files.post_files.mimes'),
        ];
    }

    public function attributes()
    {
        return [
            'title_'.config('custom.language.default') => 'Title',
            'slug' => 'Slug',
            'category_id' => 'Category',
            'files' => 'File',
        ];
    }
}
