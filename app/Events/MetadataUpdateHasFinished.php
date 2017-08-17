<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;


class MetadataUpdateHasFinished
{
   use Dispatchable, InteractsWithSockets, SerializesModels;
   
    public $provider;
    public $database;

    public $attributes;


    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($provider, $database)
    {
        $this->provider = $provider;
        $this->database = $database;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
