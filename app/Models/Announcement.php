<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Announcement extends Model
{
    protected $fillable = [
        'judul',
        'slug',
        'ringkasan',
        'isi',
        'lampiran',
        'published_at',
        'status',
        'featured',
    ];

    protected $casts = [
        'published_at' => 'date',
        'featured' => 'boolean',
    ];

    protected static function booted()
    {
        static::saving(function ($announcement) {
            if (empty($announcement->slug) && !empty($announcement->judul)) {
                $announcement->slug = Str::slug($announcement->judul);
            }
        });
    }
}
