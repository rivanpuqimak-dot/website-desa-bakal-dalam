<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Potential extends Model
{
    protected $fillable = [
        'nama',
        'slug',
        'kategori',
        'lokasi',
        'excerpt',
        'deskripsi',
        'gambar',
        'status',
        'featured',
    ];

    protected static function booted()
    {
        static::saving(function ($potential) {
            if (empty($potential->slug) && !empty($potential->nama)) {
                $potential->slug = Str::slug($potential->nama);
            }
        });
    }
}