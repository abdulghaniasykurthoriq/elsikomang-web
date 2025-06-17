<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'produk_umkm_id',
        'varian',
        'berat',
        'harga',
        'stok',
        'created_by',
        'updated_by',
    ];
    protected $hidden = [
        'produk_umkm_id',
        'created_by',
        'updated_by',
    ];

    public function produk_umkm()
    {
        return $this->belongsTo(ProdukUmkm::class, 'produk_umkm_id');
    }
}
