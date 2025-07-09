<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SawKriteria extends Model
{
    use HasFactory;

    protected $table = 'saw_kriterias';

    protected $fillable = [
        'nama',
        'label',
        'tipe',
    ];
}
