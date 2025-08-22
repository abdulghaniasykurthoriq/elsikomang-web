<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alamat extends Model
{
    protected $table = 'addresses';

    protected $fillable = [
        'provinsi_id',
        'kota_id',
        'kecamatan_id',
        'desa_id',
        'kode_pos',
        'detail',
        'kota',
        'kecamatan',
        'default',
        'user_id',
        'no_hp',
        'nama_penerima',
    ];
    protected $hidden = [
        'provinsi_id',
        'kota_id',
        'kecamatan_id',
        'desa_id',
        'user_id',
    ];
    

    // Relasi ke tabel Desa
    public function desa()
    {
        return $this->belongsTo(Desa::class);
    }

    // Relasi ke tabel User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Optional: Relasi ke Provinsi, Kota, Kecamatan
    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class);
    }

    public function kota()
    {
        return $this->belongsTo(Kota::class);
    }

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class);
    }
}
