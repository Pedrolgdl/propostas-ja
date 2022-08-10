<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'name' => 'string|max:255',
            'surname' => 'string|max:255',
            'telephone' => 'string|max:30',
            'email' => 'string|max:255|unique:users,email',
            'password' => 'string|min:6',
            'user_id' => 'Integer',
            'property_id' => 'Integer',
        ];
    }
}
