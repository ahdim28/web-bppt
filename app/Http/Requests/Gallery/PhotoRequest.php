<?php

namespace App\Http\Requests\Gallery;

use Illuminate\Foundation\Http\FormRequest;

class PhotoRequest extends FormRequest
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
                'file' => 'required|mimes:'.config('custom.files.gallery.photo.mimes'),
            ];

        } else {
            
            return [
                'file' => 'nullable|mimes:'.config('custom.files.gallery.photo.mimes'),
            ];

        }
        
    }

    public function attributes()
    {
        return [
            'file' => 'File',
        ];
    }
}
