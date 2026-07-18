<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VillageStatistic extends Model
{
    protected $table = 'village_statistics';

    protected $fillable = [
        'jumlah_penduduk',
        'jumlah_kk',
        'jumlah_dusun',
        'jumlah_rt',
        'jumlah_rw',
        'luas_wilayah',
        'luas_sawah',
        'luas_perkebunan',
        'jumlah_umkm',
        'jumlah_masjid',
        'jumlah_musala',
        'jumlah_sekolah',
        'jumlah_posyandu',
    ];
}
