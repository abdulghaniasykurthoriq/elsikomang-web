<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Pariwisata extends Model
{
    use HasFactory;

    protected $table = 'pariwisatas';

    protected $fillable = ['nama', 'deskripsi', 'gambar', 'harga_tiket', 'rating', 'jam_buka', 'jam_tutup', 'kategori', 'latitude', 'longitude', 'alamat'];

    public function fasilitas()
    {
        return $this->belongsToMany(Fasilitas::class, 'fasilitas_pariwisata');
    }

    public function ratings()
    {
        return $this->hasMany(PariwisataRating::class);
    }


    public function getDurasiOperasionalAttribute()
    {
        if (!$this->jam_buka || !$this->jam_tutup) {
            return 0;
        }

        return Carbon::parse($this->jam_tutup)->diffInHours(Carbon::parse($this->jam_buka));
    }

    public function getGambarUrlAttribute()
    {
        return $this->gambar ? asset('storage/' . $this->gambar) : null;
    }
}
