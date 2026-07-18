<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Institution extends Model
{
    protected $fillable = [
        'nama',
        'jabatan',
        'deskripsi',
        'foto',
        'sort_order',
        'status',
    ];
}