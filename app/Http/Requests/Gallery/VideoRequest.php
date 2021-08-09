<?php

namespace App\Http\Requests\Gallery;

use Illuminate\Foundation\Http\FormRequest;

class VideoRequest extends FormRequest
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
            
            if ((bool)$this->is_youtube == 0) {

                return [
                    'file' => 'required|mimes:'.config('custom.files.gallery.video.mimes'),
                    'thumbnail' => 'nullable|mimes:'.config('custom.files.gallery.video.thumbnail.mimes'),
                ];
                
    
            } else {
    
                return [
                    'youtube_id' => 'required',
                ];
                
            }

        } else {

            if ((bool)$this->is_youtube == 0) {

                return [
                    'file' => 'nullable|mimes:'.config('custom.files.gallery.video.mimes'),
                    'thumbnail' => 'nullable|mimes:'.config('custom.files.gallery.video.thumbnail.mimes'),
                ];
    
            } else {

                return [
                    'youtube_id' => 'required',
                ];
                
            }

        }
    }

    public function attributes()
    {
        return [
            'youtube_id' => 'Youtube ID',
            'file' => 'File',
            'thumbnail' => 'Thumbnail',
        ];
    }
}
