<?php

namespace LaravelVueJs\Models;

use Spatie\MediaLibrary\Models\Media as SpatieMedia;

class Media extends SpatieMedia
{
    /**
     * Get the user's Image Url.
     *
     * @return string
     */
    public function getFullUrlAttribute(): string
    {
        return $this->getFullUrl();
    }
}
