<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SawBobot extends Model
{
    use HasFactory;

    protected $table = 'saw_bobots';

    protected $fillable = [
        'kriteria',
        'bobot',
    ];
}
