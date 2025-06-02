<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IklanData extends Model
{
    protected $fillable = [
        'iklan_id',
        'gambar',
        'link',
        'status',
        'expired_at',
    ];

    public function iklan()
    {
        return $this->belongsTo(Iklan::class, 'iklan_id');
    }
}
