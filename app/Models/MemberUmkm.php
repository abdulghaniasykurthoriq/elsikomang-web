<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberUmkm extends Model
{
    protected $table = 'member_umkm';

    protected $fillable = [
        'nama_toko',
        'alamat',
        'no_hp',
        'foto_toko',
        'created_by',
        'updated_by',
    ];}
