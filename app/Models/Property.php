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

    // Conexão com tabela users
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Conexão com tabela favorites
    public function favorite()
    {
        return $this->belongsToMany(User::class, 'favorites');
    }

    // Conexão com tabela proposals
    public function proposal()
    {
        return $this->belongsToMany(User::class, 'proposals');
    }

    // Conexão com tabela visit_scheduling
    public function visit_schedule()
    {
        return $this->belongsToMany(User::class, 'visit_scheduling');
    }
}
