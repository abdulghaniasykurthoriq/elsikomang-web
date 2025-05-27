<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SplashScreen extends Model
{
    protected $fillable = [
        'id',
        'image_content',
        'image_footer'
    ];

    public function getImageContentAttribute($value)
    {
        return $value ? url('storage/' . $value) : null;
    }

    // Accessor untuk image_footer
    public function getImageFooterAttribute($value)
    {
        return $value ? url('storage/' . $value) : null;
    }
}
