<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PariwisataRating extends Model
{
    use HasFactory;

    protected $table = 'pariwisata_ratings';

    protected $fillable = [
        'user_id',
        'pariwisata_id',
        'rating',
    ];

    public function pariwisata()
    {
        return $this->belongsTo(Pariwisata::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
