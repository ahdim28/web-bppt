<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class ProfilePhotoRequest extends FormRequest
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
            'avatars' => 'nullable|max:'.config('custom.files.avatars.size').'
                |mimes:'.config('custom.files.avatars.mimes'),
        ];
    }

    public function attributes()
    {
        return [
            'avatars' => __('mod/users.user.label.field10'),
        ];
    }
}
