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
            'user_id', 
            'confirmed', 
            'type', 
            'title', 
            'description', 
            'price', 
            'iptu', 
            'size', 
            'number_rooms', 
            'number_bathrooms', 
            'furnished', 
            'disability_access', 
            'accepts_pet', 
            'garage', 
            'apartment_floor', 
            'condominium', 
            'condominium_description',  
            'fire_insurance', 
            'service_charge', 
            'state', 
            'cep', 
            'city', 
            'neighborhood', 
            'street', 
            'house_number', 
            'nearby'
        ];
    }
}
