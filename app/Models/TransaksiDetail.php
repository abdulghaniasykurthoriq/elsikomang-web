<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiDetail extends Model
{

    protected $fillable = [
        'transaksi_id',
        'produk_id',
        'produk_variant_id',
        'qty',
        'harga'
    ];

    public function produkVariant()
    {
        return $this->belongsTo(ProdukVariant::class, 'produk_variant_id');
    }
    public function produkUmkm()
    {
        return $this->belongsTo(ProdukUmkm::class, 'produk_id');
    }
}
