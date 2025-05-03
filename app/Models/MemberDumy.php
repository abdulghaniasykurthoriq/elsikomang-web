<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MemberDumy extends Model
{


    public function member_keranjang(): HasMany
    {
        return $this->hasMany(KeranjangKuDumy::class,'member_id'); // Asumsi ada model User
    }
}
