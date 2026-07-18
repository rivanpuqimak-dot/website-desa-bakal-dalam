<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'kategori',
        'tanggal_kegiatan',
        'description',
        'gambar',
        'status',
        'featured',
    ];

    protected $casts = [
        'tanggal_kegiatan' => 'date',
        'featured' => 'boolean',
    ];
}
