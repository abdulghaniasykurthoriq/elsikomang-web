<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pariwisata extends Model
{
    use HasFactory;

    protected $table = 'pariwisatas';

    protected $fillable = [
        'nama',
        'deskripsi',
        'gambar',
        'harga_tiket',
        'kategori',
        'rating',
        'latitude',
        'longitude',
    ];

    // Relasi ke fasilitas (many-to-many)
    public function fasilitas()
    {
        return $this->belongsToMany(Fasilitas::class, 'fasilitas_pariwisata');
    }

    // Relasi ke rating user (one-to-many)
    public function ratings()
    {
        return $this->hasMany(PariwisataRating::class);
    }
    protected $appends = ['gambar_url',];

    public function getGambarUrlAttribute()
    {
        return $this->gambar ? asset('storage/' . $this->gambar) : null;
    }

    
    
}
