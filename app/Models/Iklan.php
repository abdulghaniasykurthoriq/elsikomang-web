<?php

namespace App\Models;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Iklan extends Model
{
    protected $fillable = ['nama', 'slug'];

    public function iklanData()
    {
        return $this->hasMany(IklanData::class, 'iklan_id', 'id');
    }

    public function setNamaAttribute($value)
    {
        $this->attributes['nama'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }
}
