<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ProdukImage;
use App\Models\MemberUmkm;
use App\Models\KategoriProduk;

class ProdukUmkm extends Model
{
    protected $table = 'produk_umkm';

    protected $fillable = [
        'member_id',
        'nama_produk',
        'kategori_id',
        'deskripsi',
        'created_by',
        'updated_by',
    ];
    protected $hidden = [
        'created_by',
        'kategori_id',
        'member_id',
    ];
    public function produk_variant()
    {
        return $this->hasMany(ProdukVariant::class, 'produk_umkm_id');
    }


    public function images()
    {
        return $this->hasMany(ProdukImage::class, 'produk_umkm_id');
    }

    public function member()
    {
        return $this->belongsTo(MemberUmkm::class, 'member_id');
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriProduk::class, 'kategori_id');
    }
}
