<?php

namespace LaravelVueJs\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use LaravelVueJs\Events\PostViewed;

class PostViewsIncrement
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  PostViewed $event
     *
     * @return void
     */
    public function handle(PostViewed $event)
    {
        if ($event->post)
            $event->post->increment('views');
    }
}
