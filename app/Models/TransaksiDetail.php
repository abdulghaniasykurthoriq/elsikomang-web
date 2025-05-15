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
}
