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
            'unit_code' => $this->method() == 'POST' ? 'required|unique:structure_organizations,unit_code' : 
                'required|unique:structure_organizations,unit_code,'.$this->id,
            'name_'.config('custom.language.default') => 'required',
            // 'slug' => $this->method() == 'POST' ? 'required|max:50|unique:structure_organizations,slug' : 
            //     'required|max:50|unique:structure_organizations,slug,'.$this->id,
            'slug' => $this->method() == 'POST' ? 'required|unique:structure_organizations,slug' : 
                'required|unique:structure_organizations,slug,'.$this->id,
        ];
    }

    public function attributes()
    {
        return [
            'unit_code' => 'Unit Code',
            'name_'.config('custom.language.default') => 'Name',
            'slug' => 'Slug',
        ];
    }
}
