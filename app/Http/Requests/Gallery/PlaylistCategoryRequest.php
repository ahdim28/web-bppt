<?php

namespace App\Http\Requests\Gallery;

use Illuminate\Foundation\Http\FormRequest;

class PlaylistCategoryRequest extends FormRequest
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
            // 'slug' => $this->method() == 'POST' ? 'required|max:50|unique:gallery_playlist_categories,slug' : 
            //     'required|max:50|unique:gallery_playlist_categories,slug,'.$this->id,
            'slug' => $this->method() == 'POST' ? 'required|unique:gallery_playlist_categories,slug' : 
                'required|unique:gallery_playlist_categories,slug,'.$this->id,
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
