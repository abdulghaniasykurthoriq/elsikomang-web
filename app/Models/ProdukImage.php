<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProdukImage extends Model
{
    protected $table = 'produk_image'; 

    protected $fillable = [
        'produk_umkm_id',
        'file_path',
        'type',
    ];

    public function produkUmkm()
    {
        return $this->belongsTo(ProdukUmkm::class, 'produk_umkm_id');
    }
}
