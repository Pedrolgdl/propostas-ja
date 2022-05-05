<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'confirmed', 'type', 'title', 'description', 'price',
        'size', 'number_rooms', 'number_bathrooms', 'furnished', 'disability_access',
        'garage', 'cep', 'city', 'neighborhood', 'street', 'house_number', 
        'apartment_floor', 'iptu', 'condominium', 'fire_insurance', 'service_charge'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
