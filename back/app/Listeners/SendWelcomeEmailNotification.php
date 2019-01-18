<?php

namespace LaravelVueJs\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use LaravelVueJs\Notifications\SendWelcomeEmail;

class SendWelcomeEmailNotification
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
     * @param object $event
     *
     * @return void
     */
    public function handle($event)
    {
        $event->user->notify(new SendWelcomeEmail());
    }
}
