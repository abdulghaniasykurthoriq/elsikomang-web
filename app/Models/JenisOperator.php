<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisOperator extends Model
{
    public function users()
    {
        return $this->hasMany(User::class);
    }

    protected $fillable = [
        'id',
        'name',
        'url',
        'url_parameter',
    ];
}
