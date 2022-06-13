<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'property_id',
        'type',
        'document'
    ];

    // Conexão com tabela users
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Conexão com tabela properties
    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
