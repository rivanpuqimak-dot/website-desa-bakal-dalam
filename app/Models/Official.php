<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Official extends Model
{
    protected $fillable = [
        'nama',
        'nip',
        'jabatan',
        'deskripsi',
        'kata_sambutan',
        'foto',
        'sort_order',
        'status',
    ];
}
