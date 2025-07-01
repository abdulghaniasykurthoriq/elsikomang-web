<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SawRanking extends Model
{
    use HasFactory;

    protected $table = 'saw_rankings';

    protected $fillable = [
        'pariwisata_id',
        'peringkat',
        'skor_total',
    ];

    // Relasi ke model Pariwisata
    public function pariwisata()
    {
        return $this->belongsTo(Pariwisata::class);
    }
}
