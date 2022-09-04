<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;

    // Atributos do mass assignment
    protected $fillable = [
        'property_id',
        'photo',
        'is_thumb'
    ];

    // Conexão com tabela properties
    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
