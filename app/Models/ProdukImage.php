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
    protected $hidden = [
        'produk_umkm_id',
    ];
    

    public function produkUmkm()
    {
        return $this->belongsTo(ProdukUmkm::class, 'produk_umkm_id');
    }
    protected $appends = ['file_path_url',];

    public function getFilePathUrlAttribute()
    {
        return $this->file_path ? asset('storage/' . $this->file_path) : null;
    }
}
