<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProdukVarianDumy extends Model
{
    protected $fillable = [
        'produk_id',
        'varian',
        'harga',
        'stok',
    ];

    public function produk()
    {
        return $this->belongsTo(ProdukDumy::class);
    }
}
