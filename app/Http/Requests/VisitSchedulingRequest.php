<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VisitSchedulingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => 'integer', 
            'property_id' => 'integer',
            'date' => 'date',
            'schedule' => 'time',
            'status' => [ Rule::in(['Em espera', 'Marcada', 'Feita', 'Rejeitada']) ]
        ];
    }
}
