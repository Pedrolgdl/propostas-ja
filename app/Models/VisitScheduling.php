<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitScheduling extends Model
{
    use HasFactory;

    // Desativando timestamps
    public $timestamps = false;

    protected $fillable = [
        'user_id', 
        'property_id',
        'date',
        'schedule',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
