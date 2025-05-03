<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProdukFotoDumy extends Model
{
    protected $fillable = [
        'produk_id',
        'foto_url',
    ];

    // protected $appends = ['foto_url'];

    // public function getFotoAttribute($value)
    // {
    //     return $value;
    // }

    // public function getFotoUrlAttribute()
    // { 
    //     return $this->foto ? asset('storage/' . $this->foto) : null;
    // }
}
