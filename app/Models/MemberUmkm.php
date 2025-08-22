<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberUmkm extends Model
{
    protected $table = 'msme_members';

    protected $fillable = [
        'nama_toko',
        'alamat',
        'no_hp',
        'foto_toko',
        'desa_id',
        'created_by',
        'updated_by',
    ];
    protected $hidden = [
        'created_by',
        'updated_by',
    ];

    public function desa()
    {
        return $this->belongsTo(Desa::class);
    }

        // Relasi dengan ProdukUmkm
        public function produkUmkm()
        {
            return $this->hasMany(ProdukUmkm::class, 'member_id');
        }

        protected $appends = ['foto_toko_url',];

    public function getFotoTokoUrlAttribute()
    {
        return $this->foto_toko ? asset('storage/' . $this->foto_toko) : null;
    }

    
}
