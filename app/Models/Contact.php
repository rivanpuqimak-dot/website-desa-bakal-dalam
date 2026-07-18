<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'telepon',
        'whatsapp',
        'email',
        'website',
        'facebook',
        'instagram',
        'youtube',
        'tiktok',
        'alamat',
        'jam_operasional',
        'google_maps',
        'google_maps_embed',
    ];
}