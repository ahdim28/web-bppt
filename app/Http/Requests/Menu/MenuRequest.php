<?php

namespace App\Http\Requests\Menu;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;

class MenuRequest extends FormRequest
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
        if ((bool)$this->not_from_module == 1) {
            
            return [
                'title_'.config('custom.language.default') => 'required',
                'url' => 'required'
            ];
            
        } else {
            
            return [
                'module' => 'required',
                'module_content' => 'required',
            ];

        }
    }

    public function attributes()
    {
        return [
            'title_'.config('custom.language.default') => __('mod/menu.label.field2'),
            'url' => __('mod/menu.label.field4'),
            'module' => __('mod/menu.label.field5'),
            'module_content' => __('mod/menu.label.field6'),
        ];
    }
}
