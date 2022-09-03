<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'user_id' => 'integer', 
            'confirmed' => 'boolean', 
            'type' => [ Rule::in(['Casa', 'Apartamento', 'Kitnet']) ], 
            'title' => 'string|max:255', 
            'description' => 'string', 
            'price' => 'numeric', 
            'iptu' => 'numeric', 
            'size' => 'integer', 
            'number_rooms' => 'integer', 
            'number_bathrooms' => 'integer', 
            'furnished' => 'boolean', 
            'disability_access' => 'boolean', 
            'accepts_pet' => 'boolean', 
            'garage' => 'integer', 
            'apartment_floor' => 'integer', 
            'condominium' => 'numeric', 
            'condominium_description' => 'string',  
            'fire_insurance' => 'numeric', 
            'service_charge' => 'numeric', 
            'state' => 'string|max:20', 
            'cep' => 'string|max:9', 
            'city' => 'string|max:30', 
            'neighborhood' => 'string|max:40', 
            'street' => 'string|max:40', 
            'house_number' => 'integer', 
            'nearby' => 'string'
        ];
    }
}
