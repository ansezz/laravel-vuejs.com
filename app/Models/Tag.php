<?php

namespace LaravelVueJs\Models;

use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;
use \Spatie\Tags\Tag as SpatieTag;

class Tag extends SpatieTag implements Feedable
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

    /**
     * Get the Post Url.
     *
     * @return string
     */
    public function getUrlAttribute(): string
    {
        return url('/tag/' . $this->slug);
    }

    /**
     * @return array|FeedItem
     */
    public function toFeedItem()
    {
        return FeedItem::create()
            ->id($this->id)
            ->title($this->name)
            ->summary($this->description ?? $this->name)
            ->updated($this->updated_at)
            ->link($this->url)
            ->author(config('app.name'));
    }
}
