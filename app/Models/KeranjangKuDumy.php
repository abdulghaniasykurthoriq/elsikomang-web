<?php

 namespace App\Models;

 use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\Relations\BelongsTo;

 class KeranjangKuDumy extends Model
 {
  protected $fillable = [
  'varian_id',
  'jumlah',
  'user_id',
  'member_id',
  // Kolom lain di tabel keranjang Anda
  ];

  protected $appends = ['varian_nama','varian_harga','nama_produk','foto_produk'];

  protected $hidden = ['varian']; // Tambahkan baris ini

  public function varian(): BelongsTo
  {
    return $this->belongsTo(ProdukVarianDumy::class, 'varian_id');
  }

  public function getVarianNamaAttribute()
  {
        return $this->varian->nama_varian ?? null;
  }
  public function getVarianHargaAttribute()
  {
        return $this->varian->harga ?? null;
  }
  public function getNamaProdukAttribute()
  {
        return $this->varian->produk->nama_produk ?? null;
  }
  public function getFotoProdukAttribute()
  {
        return $this->varian->produk->fotoDumies->first()->foto_url ?? null;
  }
  

  
  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class); // Asumsi ada model User
  }
  public function member(): BelongsTo
  {
    return $this->belongsTo(MemberDumy::class); // Asumsi ada model User
  }
 }