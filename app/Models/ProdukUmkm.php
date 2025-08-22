<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ProdukImage;
use App\Models\MemberUmkm;
use App\Models\KategoriProduk;

class ProdukUmkm extends Model
{
    protected $table = 'msme_products';

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
    protected $appends = ['image_url']; // agar ikut saat di-convert ke JSON
    public function getImageUrlAttribute()
    {
        $image = $this->images
            ->where('type', 'image')
            ->first();
    
        return $image ? $image->url : null;
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
