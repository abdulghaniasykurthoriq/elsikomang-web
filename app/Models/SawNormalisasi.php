<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SawNormalisasi extends Model
{
    use HasFactory;

    protected $table = 'saw_normalisasis';

    protected $fillable = [
        'pariwisata_id',
        'kriteria',
        'nilai_normalisasi', // ✅ sesuai dengan nama kolom di database
        'rumus',
    ];

    public function pariwisata()
    {
        return $this->belongsTo(Pariwisata::class);
    }
}
