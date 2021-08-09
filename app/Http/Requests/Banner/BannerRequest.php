<?php

namespace App\Http\Requests\Banner;

use Illuminate\Foundation\Http\FormRequest;

class BannerRequest extends FormRequest
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
            
            if ((bool)$this->is_youtube == 1) {

                return [
                    'youtube_id' => 'required',
                ];
    
            } else {
    
                if ((bool)$this->is_video == 1) {
                    return [
                        'file' => 'required|mimes:'.config('custom.files.banner.mimes_video'),
                        'thumbnail' => 'nullable|mimes:'.config('custom.files.banner.thumbnail.mimes'),
                    ];
                } else {
                    return [
                        'file' => 'required|mimes:'.config('custom.files.banner.mimes'),
                        'thumbnail' => 'nullable|mimes:'.config('custom.files.banner.thumbnail.mimes'),
                    ];
                }
                
            }

        } else {

            if ((bool)$this->is_youtube == 1) {

                return [
                    'youtube_id' => 'required',
                ];
    
            } else {
    
                if ((bool)$this->is_video == 1) {
                    return [
                        'file' => 'nullable|mimes:'.config('custom.files.banner.mimes_video'),
                        'thumbnail' => 'nullable|mimes:'.config('custom.files.banner.thumbnail.mimes'),
                    ];
                } else {
                    return [
                        'file' => 'nullable|mimes:'.config('custom.files.banner.mimes'),
                        'thumbnail' => 'nullable|mimes:'.config('custom.files.banner.thumbnail.mimes'),
                    ];
                }
                
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
