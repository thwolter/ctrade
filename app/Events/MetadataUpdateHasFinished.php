<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Carbon\Carbon;


class MetadataUpdateHasFinished
{
   use Dispatchable, InteractsWithSockets, SerializesModels;
   
    public $provider;
    public $database;
    public $timestamp;


    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($provider, $database)
    {
        $this->provider = $provider;
        $this->database = $database;

        $this->timestamp = Carbon::now();
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
