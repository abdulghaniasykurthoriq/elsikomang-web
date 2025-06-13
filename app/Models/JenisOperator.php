<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisOperator extends Model
{
    public function users()
    {
        return $this->hasMany(User::class);
        return $this->belongsTo(JenisOperator::class, 'jenis_operator_id');
    }

    protected $fillable = [
        'id',
        'name',
        'url',
        'url_parameter',
    ];
}
