<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Serial extends Model
{
    protected $guarded = ['id'];
    protected $casts = [
        'preferred_date' => 'date',
        'medical_reports' => 'array',
        'sms_sent_at' => 'datetime',
    ];

    public function chamber()
    {
        return $this->belongsTo(Chamber::class);
    }

    public function prescription()
    {
        return $this->hasOne(Prescription::class);
    }
}

