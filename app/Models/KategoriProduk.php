<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriProduk extends Model
{
    
        // use HasFactory;
    
        protected $table = 'kategori_produk';
    
        protected $fillable = ['name'];

        protected $hidden = [
        'id'
    ];
    
        // Relasi ke produk_umkm
        // public function produkUmkm()
        // {
        //     return $this->hasMany(ProdukUmkm::class, 'kategori_id');
        // }
    }
