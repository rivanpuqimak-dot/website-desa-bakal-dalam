<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $fillable = [
        'deskripsi',
        'luas_wilayah',
        'jumlah_dusun',
        'batas_utara',
        'batas_selatan',
        'batas_timur',
        'batas_barat',
        'google_maps',
        'google_maps_embed',
        'map_image',
    ];
}



