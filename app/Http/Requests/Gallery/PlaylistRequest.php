<?php

namespace App\Http\Requests\Gallery;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;

class PlaylistRequest extends FormRequest
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
            'category_id' => 'required',
            'name_'.config('custom.language.default') => 'required',
            // 'slug' => $this->method() == 'POST' ? 'required|max:50|unique:gallery_playlists,slug' : 
            //     'required|max:50|unique:gallery_playlists,slug,'.$this->id,
            'slug' => $this->method() == 'POST' ? 'required|unique:gallery_playlists,slug' : 
                'required|unique:gallery_playlists,slug,'.$this->id,
        ];
    }

    public function attributes()
    {
        return [
            'category_id' => 'Category',
            'name_'.config('custom.language.default') => 'Name',
            'slug' => 'Slug',
        ];
    }
}
