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
            'confirmed' => 'required', 
            'type' => 'required', 
            'title' => 'required', 
            'description', 
            'price' => 'required',
            'size' => 'required', 
            'number_rooms' => 'required', 
            'number_bathrooms' => 'required', 
            'furnished' => 'required', 
            'disability_access' => 'required',
            'garage', 
            'cep' => 'required', 
            'city' => 'required', 
            'neighborhood' => 'required', 
            'street' => 'required', 
            'house_number' => 'required', 
            'apartment_floor', 
            'iptu' => 'required', 
            'condominium', 
            'fire_insurance', 
            'service_charge'
        ];
    }
}
