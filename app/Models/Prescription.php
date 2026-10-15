<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    protected $guarded = ['id'];
    protected $casts = [
        'consultation_date' => 'date',
        'next_visit_date' => 'date',
        'medicines' => 'array',
        'investigations' => 'array',
    ];

    public function serial()
    {
        return $this->belongsTo(Serial::class);
    }

    public function chamber()
    {
        return $this->belongsTo(Chamber::class);
    }
}

