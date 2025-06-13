<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Provinsi extends Model
{
    protected $guarded = [];

    public function kota()
    {
        return $this->hasMany(Kota::class, 'provinsi_id');
    }

    public function getKotaCountAttribute()
    {
        return $this->kota()->count();
    }

    public function getKecamatanCountAttribute()
    {
        return $this->kota()->withCount('kecamatan')->get()->sum('kecamatan_count');
    }

    public function getDesaCountAttribute()
    {
        return $this->kota()->withCount(['kecamatan' => function ($query) {
            $query->withCount('desa');
        }])->get()->sum(function ($kota) {
            return $kota->kecamatan_count;
        });
    }
}
