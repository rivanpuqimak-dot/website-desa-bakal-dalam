<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VillageService extends Model
{
    protected $fillable = [
        'title',
        'icon',
        'description',
        'requirements',
        'processing_time',
        'cost',
        'sort_order',
        'status',
    ];

    protected $casts = [
        'requirements' => 'array',
        'sort_order' => 'integer',
    ];
}
