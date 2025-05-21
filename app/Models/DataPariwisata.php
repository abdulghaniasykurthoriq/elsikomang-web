<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataPariwisata extends Model
{
    protected $table = 'data_pariwisata';
    protected $fillable = ['nama', 'lokasi', 'deskripsi', 'galeri'];
}
