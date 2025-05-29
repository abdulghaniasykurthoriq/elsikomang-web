<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fasilitas extends Model
{
    use HasFactory;

    protected $fillable = ['nama'];

    public function pariwisata()
    {
        return $this->belongsToMany(Pariwisata::class, 'fasilitas_pariwisata');
    }
}
