<?php

namespace LaravelVueJs\Models;

use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;
use Spatie\MediaLibrary\Models\Media as SpatieMedia;

class Media extends SpatieMedia implements Feedable
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


    /**
     * @return array|FeedItem
     */
    public function toFeedItem()
    {
        return FeedItem::create()
            ->id($this->id)
            ->title($this->name)
            ->summary($this->name)
            ->updated($this->updated_at)
            ->link($this->full_url)
            ->author(config('app.name'));
    }
}
