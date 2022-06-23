<?php

namespace App\Listeners;

use App\Events\NewsCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogNews
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
     * @param NewsCreated $event
     * @return void
     */
    public function handle(NewsCreated $event)
    {
        \Log::info(print_r($event->news, true));
    }
}
