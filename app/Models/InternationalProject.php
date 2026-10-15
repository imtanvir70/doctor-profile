<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InternationalProject extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'display_order' => 'integer',
    ];
}

