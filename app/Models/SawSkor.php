<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SawSkor extends Model
{
    use HasFactory;

    protected $table = 'saw_skors';

    protected $fillable = [
        'pariwisata_id',
        'skor_total',
    ];

    public function pariwisata()
    {
        return $this->belongsTo(Pariwisata::class);
    }
}
