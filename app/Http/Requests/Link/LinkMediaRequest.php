<?php

namespace App\Http\Requests\Link;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;

class LinkMediaRequest extends FormRequest
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
            'url' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'title_'.config('custom.language.default') => 'Title',
            'url' => 'URL',
        ];
    }
}
