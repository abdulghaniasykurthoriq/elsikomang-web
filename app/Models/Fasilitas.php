<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fasilitas extends Model
{
    use HasFactory;

    protected $fillable = ['nama'];

    // Relasi Many-to-Many ke pariwisata
    public function pariwisatas()
    {
        return $this->belongsToMany(Pariwisata::class, 'fasilitas_pariwisata');
    }
}
