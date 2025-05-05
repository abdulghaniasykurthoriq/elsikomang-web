<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    protected $table = 'keranjangs';

    protected $fillable = [
        'user_id',
        'member_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function member()
    {
        return $this->belongsTo(MemberUmkm::class, 'member_id');
    }
    public function keranjangDetail()
    {
        return $this->hasMany(KeranjangDetail::class);
    }

    
      protected $appends = ['member_nama','member_foto'];
      protected $hidden = ['member'];
      


      public function getMemberNamaAttribute()
      {
          return $this->member->nama_toko;
      }
      public function getMemberFotoAttribute()
      {
          return $this->member->foto_toko_url;
      }

}
