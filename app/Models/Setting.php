<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'nama_website',
        'slogan',
        'logo',
        'favicon',
        'footer',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'maintenance_mode',
    ];

    protected $casts = [
        'maintenance_mode' => 'boolean',
    ];
}