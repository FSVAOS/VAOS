<?php

namespace App\Listeners;

use App\Events\AirineEventDispatched;

class EmailNotification
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
     * @param  AirineEventDispatched  $event
     *
     * @return void
     */
    public function handle(AirineEventDispatched $event)
    {
        //
    }
}
