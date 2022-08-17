<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'state', 
        'cep', 
        'city', 
        'neighborhood', 
        'street', 
        'house_number', 
        'nearby'
    ];

    // Conexão com tabela properties
    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
