<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'username',
        'tanggal_lahir',
        'jenis_kelamin',
        'no_telephon',
        'foto',
        'jenis_operator_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'jenis_operator_id'
    ];

    protected $appends = [
        'foto_url',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Relasi ke tabel jenis_operators
     */
    public function jenisOperator()
    {
        return $this->belongsTo(JenisOperator::class, 'jenis_operator_id');
    }

    /**
     * Getter untuk URL foto
     */
    public function getFotoUrlAttribute()
    {
        return $this->foto ? asset('storage/' . $this->foto) : null;
    }

    /**
     * JWT Identifier
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Custom claims untuk JWT
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function wishlistItems(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }
}
