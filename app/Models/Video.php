<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $guarded = ['id'];
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Alias for youtube_id to maintain compatibility with both naming conventions.
     */
    public function getYoutubeVideoIdAttribute(): ?string
    {
        return $this->youtube_id;
    }

    /**
     * Get the video thumbnail URL (falls back to YouTube HQ thumbnail).
     */
    public function getThumbnailUrlAttribute(): ?string
    {
        if (!empty($this->thumbnail) && !str_contains($this->thumbnail, 'unsplash.com')) {
            return $this->thumbnail;
        }

        if (!empty($this->youtube_id)) {
            return 'https://img.youtube.com/vi/' . $this->youtube_id . '/hqdefault.jpg';
        }

        return $this->thumbnail;
    }
}

