<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class News extends Model
{
    protected $fillable = [
        'judul',
        'slug',
        'excerpt',
        'isi',
        'gambar',
        'kategori',
        'penulis',
        'published_at',
        'status',
        'featured',
        'views',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'featured' => 'boolean',
    ];

    protected static function booted()
    {
        static::saving(function ($news) {
            if (empty($news->slug) && !empty($news->judul)) {
                $news->slug = Str::slug($news->judul);
            }
        });
    }
}