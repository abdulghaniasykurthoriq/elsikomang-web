<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OperatorEvent extends Model
{
    protected $table = 'operator_events';

    protected $fillable = [
        'nama_event',
        'deskripsi',
        'foto_event',
        'created_by',
        'updated_by',
    ];

    public function getFormattedLinkEventAttribute()
    {
        if (!$this->link_event) return null;

        return preg_match('/^https?:\/\//', $this->link_event)
            ? $this->link_event
            : 'https://' . $this->link_event;
    }

    protected $appends = ['gambar_url',];

    public function getGambarUrlAttribute()
    {
        return $this->foto_event ? asset('storage/' . $this->foto_event) : null;
    }
}
