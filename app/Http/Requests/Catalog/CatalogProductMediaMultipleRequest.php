<?php

namespace App\Http\Requests\Catalog;

use Illuminate\Foundation\Http\FormRequest;

class CatalogProductMediaMultipleRequest extends FormRequest
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
            'file' => 'required|mimes:'.config('custom.files.product.mimes').','.
                config('custom.files.product.mimes_video'),
        ];
    }

    public function attributes()
    {
        return [
            'file' => 'File',
        ];
    }
}
