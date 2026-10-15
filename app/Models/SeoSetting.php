<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeoSetting extends Model
{
    protected $guarded = ['id'];
    protected $casts = [
        'custom_schema_json' => 'array',
    ];
}

