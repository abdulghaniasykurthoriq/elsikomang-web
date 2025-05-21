<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanPariwisata extends Model
{

    protected $fillable = ['tanggal', 'periode', 'nama_wisata', 'jumlah_viewer'];

}
