<?php

namespace App\Http\Requests\Document;

use Illuminate\Foundation\Http\FormRequest;

class DocumentRequest extends FormRequest
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
            // 'slug' => $this->method() == 'POST' ? 'required|max:50|unique:content_categories,slug' : 
            //     'required|max:50|unique:content_categories,slug,'.$this->id,
            'slug' => $this->method() == 'POST' ? 'required|unique:documents,slug' : 
                'required|unique:documents,slug,'.$this->id,
            'file' => ($this->from == 0 && $this->method() == 'POST') ? 'required|mimes:'.config('custom.files.edocman.mimes') : 'nullable|mimes:'.config('custom.files.edocman.mimes'),
            'document_url' => $this->from == 1 ? 'required' : 'nullable',
        ];
    }

    public function attributes()
    {
        return [
            'title_'.config('custom.language.default') => 'Title',
            'slug' => 'Slug',
            'file' => 'File',
            'document_url' => 'Document URL'
        ];
    }
}
