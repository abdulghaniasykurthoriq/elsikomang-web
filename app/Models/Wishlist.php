<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    protected $fillable = [
        'user_id',
        'produk_umkm_id',
    ];



    
    protected $hidden = [
        'id',
        'user_id',
        'produk_umkm_id',
        'created_at',
        'updated_at',
    ];









    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function produkUmkm()
    {
        return $this->belongsTo(ProdukUmkm::class);
    }

}
