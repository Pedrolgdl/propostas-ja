<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'surname',
        'telephone',
        'role',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Conexão com tabela properties
    public function property()
    {
        return $this->hasMany(Property::class);
    }

    // Conexão com tabela favorites
    public function favorite()
    {
        return $this->belongsToMany(Property::class, 'favorites');
    }

    // Conexão com tabela proposals
    public function proposal()
    {
        return $this->belongsToMany(Property::class, 'proposals');
    }

    // Conexão com tabela visit_scheduling
    public function visit_schedule()
    {
        return $this->belongsToMany(Property::class, 'visit_scheduling');
    }
}
