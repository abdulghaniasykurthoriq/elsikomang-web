<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    protected $guarded = [];
    
    public function kota()
    {
        return $this->belongsTo(Kota::class);
    }

    public function desa()
    {
        return $this->hasMany(Desa::class);
    }
}
