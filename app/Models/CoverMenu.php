<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoverMenu extends Model
{
    protected $fillable = ['nama', 'foto'];
    
    protected $appends = ['foto_url'];

    public function getFotoAttribute($value)
    {
        return $value;
    }

    public function getFotoUrlAttribute()
    {
        return $this->foto ? asset('storage/' . $this->foto) : null;
    }
}
