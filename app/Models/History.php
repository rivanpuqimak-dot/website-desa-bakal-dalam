<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $fillable = [
        'judul',
        'year_established',
        'excerpt',
        'sejarah',
        'gambar',
    ];
}