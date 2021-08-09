<?php

namespace App\Http\Requests\Catalog;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;

class CatalogProductRequest extends FormRequest
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
            'slug' => $this->method() == 'POST' ? 'required|max:50|unique:catalog_products,slug' : 
                'required|max:50|unique:catalog_products,slug,'.$this->id,
            'category_id' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'title_'.config('custom.language.default') => 'Title',
            'slug' => 'Slug',
            'category_id' => 'Category',
        ];
    }
}
