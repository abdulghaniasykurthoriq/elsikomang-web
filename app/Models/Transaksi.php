<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksis';


    
    protected $fillable = [
        'user_id',
        'order_id',
        'member_id',
        'alamat_id',
        'amount',
        'payment_method',
        'snap_token',
        'snap_redirect_url',
        'status',
        'kode_voucher',
        'no_resi',
        'kurir',
        'kurir_service',
        'total_ongkos'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function transaksiDetail()
    {
        return $this->hasMany(TransaksiDetail::class, 'transaksi_id', 'id');
    }
}
