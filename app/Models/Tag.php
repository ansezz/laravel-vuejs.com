<?php

namespace LaravelVueJs\Models;

use \Spatie\Tags\Tag as SpatieTag;

class Tag extends SpatieTag
{
    public static function findFromSlug(string $slug, string $type = null, string $locale = null)
    {
        $locale = $locale ?? app()->getLocale();

        return static::query()
            ->where("slug->{$locale}", $slug)
            ->where('type', $type)
            ->first();
    }


    /**
     * Get all of the posts that are assigned this tag.
     */
    public function posts()
    {
        return $this->morphedByMany(Post::class, 'taggable');
    }
}
