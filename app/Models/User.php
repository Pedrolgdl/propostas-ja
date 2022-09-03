<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements JWTSubject
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
        'birth_date',
        'cpf',
        'role',
        'email',
        'password',
        'userPhoto',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

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
    public function properties()
    {
        return $this->hasMany(Property::class);
    }

    // Conexão com tabela documents
    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    // Conexão com tabela favorites
    public function favorites()
    {
        return $this->belongsToMany(Property::class, 'favorites', 'user_id', 'property_id');
    }

    // Conexão com tabela proposals
    public function proposals()
    {
        return $this->belongsToMany(Property::class, 'proposals', 'user_id', 'property_id');
    }

    // Conexão com tabela visit_scheduling
    public function visit_scheduling()
    {
        return $this->belongsToMany(Property::class, 'visit_scheduling');
    }
}
