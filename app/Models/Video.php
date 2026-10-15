<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $guarded = ['id'];
    protected $casts = [
        'is_active' => 'boolean',
    ];
}

