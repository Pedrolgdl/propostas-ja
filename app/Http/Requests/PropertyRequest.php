<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PropertyRequest extends FormRequest
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
            'confirmed', 
            'type', 
            'title', 
            'description', 
            'price',
            'size', 
            'number_rooms', 
            'number_bathrooms', 
            'furnished', 
            'disability_access',
            'garage', 
            'cep', 
            'city', 
            'neighborhood', 
            'street', 
            'house_number', 
            'apartment_floor', 
            'iptu', 
            'condominium', 
            'fire_insurance', 
            'service_charge'
        ];
    }
}
