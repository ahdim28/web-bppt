<?php

namespace App\Http\Requests\Inquiry;

use App\Services\Inquiry\InquiryService;
use Illuminate\Foundation\Http\FormRequest;

class InquiryFormRequest extends FormRequest
{
    private $inquiry;

    public function __construct(
        InquiryService $inquiry
    )
    {
        $this->inquiry = $inquiry;
    }

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
        $inquiry = $this->inquiry->find($this->id);
        
        $fields['g-recaptcha-response'] = 'recaptcha';
        foreach ($inquiry->inquiryField as $key => $value) {
            $fields[$value->name] = $value->validation;
        }

        return $fields;
    }

    public function attributes()
    {
        $inquiry = $this->inquiry->find($this->id);
        
        $fields['g-recaptcha-response'] = 'Recaptcha';
        foreach ($inquiry->inquiryField as $key => $value) {
            $fields[$value->name] = $value->fieldLang('label');
        }

        return $fields;
    }

    public function messages()
    {
        $inquiry = $this->inquiry->find($this->id);
        
        $fields['g-recaptcha-response.recaptcha'] = ':attribute must be verification';
        foreach ($inquiry->inquiryField as $key => $value) {
            $fields[$value->name.'.required'] = ':attribute is required';
        }

        return $fields;
    }
}
