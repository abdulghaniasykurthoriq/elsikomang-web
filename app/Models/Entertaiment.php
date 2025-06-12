<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entertaiment extends Model
{
    use HasFactory;

    protected $fillable = [
        'foto_entertaiment',
        'nama_entertaiment',
        'deskripsi',
        'created_by',
        'updated_by',
    ];

    protected $appends = ['gambar_url',];

    public function getGambarUrlAttribute()
    {
        return $this->foto_entertaiment ? asset('storage/' . $this->foto_entertaiment) : null;
    }
}
