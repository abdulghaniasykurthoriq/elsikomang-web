<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProdukDumy extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_produk',
        'deskripsi',
        'member_id',
    ];

    public function member(): BelongsTo
    {
        return $this->belongsTo(MemberDumy::class, 'member_id');
    }
    public function varianDumies(): HasMany
    {
        return $this->hasMany(ProdukVarianDumy::class, 'produk_id');
    }
    public function fotoDumies(): HasMany
    {
        return $this->hasMany(ProdukFotoDumy::class, 'produk_id');
    }
}
