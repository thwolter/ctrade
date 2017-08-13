<?php

namespace App\Events\Limits;

use App\Entities\Limit;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class LimitHasChanged
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $limit;


    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Limit $limit)
    {
        $this->limit = $limit;
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
