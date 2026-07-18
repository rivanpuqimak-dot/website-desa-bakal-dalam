<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Agenda extends Model
{
    protected $fillable = [
        'judul',
        'slug',
        'deskripsi',
        'tanggal_mulai',
        'tanggal_selesai',
        'waktu',
        'lokasi',
        'poster',
        'status',
        'featured',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'featured' => 'boolean',
    ];

    protected static function booted()
    {
        static::saving(function ($agenda) {
            if (empty($agenda->slug) && !empty($agenda->judul)) {
                $agenda->slug = Str::slug($agenda->judul);
            }
        });
    }
}
