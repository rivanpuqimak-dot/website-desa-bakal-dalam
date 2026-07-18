<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VillageProfile extends Model
{
    protected $fillable = [
        'nama_desa',
        'village_slogan',
        'kecamatan',
        'kabupaten',
        'provinsi',
        'kode_pos',
        'hero_image',
        'cover_image',
        'office_photo',
        'logo',
        'latitude',
        'longitude',
        'struktur_organisasi',
        'struktur_bpd',
    ];
}
