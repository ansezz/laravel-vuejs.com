<?php

namespace LaravelVueJs\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use LaravelVueJs\Events\PostViewed;
use LaravelVueJs\Listeners\PostViewsIncrement;
use LaravelVueJs\Listeners\SendWelcomeEmailNotification;


class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            //  SendEmailVerificationNotification::class,
            SendWelcomeEmailNotification::class,
        ],
        PostViewed::class => [
            PostViewsIncrement::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
