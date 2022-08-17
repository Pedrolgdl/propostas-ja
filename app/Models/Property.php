<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $casts = [
        'price' => 'double',
        'iptu' => 'double',
        'condominium' => 'double',
        'fire_insurance' => 'double',
        'service_charge' => 'double',
    ];

    protected $fillable = [
        'user_id', 'confirmed', 'type', 'title', 'description', 'price', 'iptu', 'size', 
        'number_rooms', 'number_bathrooms', 'furnished', 'disability_access', 'accepts_pet', 
        'garage', 'apartment_floor', 'condominium', 'condominium_description',  'fire_insurance', 
        'service_charge', 
    ];

    // Conexão com tabela users
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Conexão com tabela photos
    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    // Conexão com tabela documents
    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    // Conexão com tabela favorites
    public function favorites()
    {
        return $this->belongsToMany(User::class, 'favorites', 'user_id', 'property_id');
    }

    // Conexão com tabela proposals
    public function proposals()
    {
        return $this->belongsToMany(User::class, 'proposals');
    }

    // Conexão com tabela visit_scheduling
    public function visit_scheduling()
    {
        return $this->belongsToMany(User::class, 'visit_scheduling');
    }
}
