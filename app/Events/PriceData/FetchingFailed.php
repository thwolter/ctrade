<?php

namespace App\Events\PriceData;

use App\Entities\Datasource;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class FetchingFailed
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $datasource;
    public $url;
    public $error;


    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Datasource $datasource,  $url, $error)
    {
        $this->datasource = $datasource;
        $this->url = $url;
        $this->error = $error;
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
