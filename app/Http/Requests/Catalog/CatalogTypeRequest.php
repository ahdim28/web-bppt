<?php

namespace App\Http\Requests\Catalog;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;

class CatalogTypeRequest extends FormRequest
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
        ];
    }

    public function attributes()
    {
        return [
            'name_'.config('custom.language.default') => 'Name',
        ];
    }
}
