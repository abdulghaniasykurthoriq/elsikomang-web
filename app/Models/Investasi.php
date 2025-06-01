<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Investasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'foto_investasi',
        'nama_investasi',
        'deskripsi',
        'created_by',
        'updated_by',
    ];}
