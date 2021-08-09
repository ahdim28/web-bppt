<?php

namespace App\Http\Requests\Banner;

use Illuminate\Foundation\Http\FormRequest;

class BannerMultipleRequest extends FormRequest
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
            'file' => 'required|mimes:'.config('custom.files.banner.mimes').','.
                config('custom.files.banner.mimes_video'),
        ];
    }

    public function attributes()
    {
        return [
            'file' => 'File',
        ];
    }
}
