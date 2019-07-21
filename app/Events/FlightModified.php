<?php

namespace App\Events;

use App\Models\Flight;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class FlightModified
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $flight;

    public function __construct(Flight $flight)
    {
        $this->flight = $flight;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
