<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Specialty extends Model
{
    protected $guarded = ['id'];
    protected $casts = [
        'tags_en' => 'array',
        'tags_bn' => 'array',
        'is_active' => 'boolean',
    ];
}

