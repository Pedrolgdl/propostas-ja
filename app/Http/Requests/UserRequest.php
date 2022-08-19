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
            'name' => 'string|max:35',
            'surname' => 'string|max:50',
            'telephone' => 'string|max:15',
            'birth_date' => 'date',
            'cpf' => 'string|max:14',
            'email' => 'string|max:255|unique:users,email',
            'password' => 'string|min:6',
            'userPhoto',
            'user_id' => 'integer',
            'property_id' => 'integer',
        ];
    }
}
