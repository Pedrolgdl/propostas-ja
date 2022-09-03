<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitScheduling extends Model
{
    use HasFactory;

    // Desativando timestamps
    public $timestamps = false;

    // Atributos do mass assignment
    protected $fillable = [
        'user_id', 
        'property_id',
        'date',
        'schedule',
        'status'
    ];

    // Conexão com tabela users
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Conexão com tabela property
    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
