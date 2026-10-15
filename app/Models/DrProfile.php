<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DrProfile extends Model
{
    protected $table = 'drprofile';
    protected $guarded = ['id'];

    /**
     * Get the resolved Favicon URL (custom or fallback default).
     */
    public function getFaviconUrlAttribute(): string
    {
        if (!empty($this->favicon)) {
            return (str_starts_with($this->favicon, 'http://') || str_starts_with($this->favicon, 'https://') || str_starts_with($this->favicon, '//'))
                ? $this->favicon
                : asset($this->favicon);
        }

        return asset('favicon.svg');
    }
}

