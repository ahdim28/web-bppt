<?php

namespace App\Http\Requests\Deputi;

use Illuminate\Foundation\Http\FormRequest;

class StructureOrganizationRequest extends FormRequest
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
            // 'sidadu_id' => 'required',
            'unit_code' => 'required',
            'name_'.config('custom.language.default') => 'required',
            'slug' => $this->method() == 'POST' ? 'required|max:50|unique:structure_organizations,slug' : 
                'required|max:50|unique:structure_organizations,slug,'.$this->id,
        ];
    }

    public function attributes()
    {
        return [
            'sidadu_id' => 'Sidadu ID',
            'unit_code' => 'Unit Code',
            'name_'.config('custom.language.default') => 'Name',
            'slug' => 'Slug',
        ];
    }
}
