<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $guarded = ['id'];
    protected $casts = [
        'is_featured' => 'boolean',
        'is_approved' => 'boolean',
        'last_visit_date' => 'date',
    ];
}

