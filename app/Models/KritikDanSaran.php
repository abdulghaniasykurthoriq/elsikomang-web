<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KritikDanSaran extends Model
{
    protected $fillable = ['nama', 'email', 'kritik', 'saran'];
}
