<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bpd extends Model
{
    protected $fillable = [
        'nama',
        'jabatan',
        'deskripsi',
        'foto',
    ];
}