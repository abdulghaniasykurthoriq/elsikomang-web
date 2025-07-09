<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KeranjangDetail extends Model
{
    protected $table = 'keranjang_details';

    protected $fillable = [
        'keranjang_id',
        'produk_umkm_id',
        'produk_variant_id',
        'jumlah',
    ];
    protected $hidden = ['keranjang_id','produk_umkm','produkUmkm', 'produkVariant'];
    
    protected $appends = ['produk_umkm_nama','produk_umkm_foto', 'produk_variant_nama', 'produk_variant_harga', 'produk_variant_stok', 'berat'];
    public function getProdukUmkmNamaAttribute()
    {
        return $this->produkUmkm->nama_produk;
    }
    
    public function getProdukUmkmFotoAttribute()
    {
        return $this->produkUmkm->images->first() ? $this->produkUmkm->images->first()->file_path_url : null;
    }

    public function getProdukVariantNamaAttribute()
    {
        return $this->produkVariant->varian;
    }
    public function getProdukVariantHargaAttribute()
    {
        return $this->produkVariant->harga;
    }
    public function getProdukVariantStokAttribute()
    {
        return $this->produkVariant->stok;
    }
    public function getBeratAttribute()
    {
        return $this->produkVariant->berat;
    }
    




    public function keranjang()
    {
        return $this->belongsTo(Keranjang::class);
    }

    public function produkUmkm()
    {
        return $this->belongsTo(ProdukUmkm::class, 'produk_umkm_id');
    }
    public function produkVariant()
    {
        return $this->belongsTo(ProdukVariant::class, 'produk_variant_id');
    }
    
}
