<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_voucher',
        'nama_voucher',
        'tipe_diskon',
        'nilai_diskon',
        'minimum_transaksi',
        'maks_diskon',
        'kuota',
        'tanggal_mulai',
        'tanggal_berakhir',
        'is_aktif',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_berakhir' => 'date',
        'is_aktif' => 'boolean',
    ];

    // ✅ Relasi: satu voucher bisa dipakai di banyak transaksi
    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }
}
