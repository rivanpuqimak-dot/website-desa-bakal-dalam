<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisionMission extends Model
{
    protected $fillable = [
        'visi',
        'misi',
        'tujuan',
        'motto',
    ];
}