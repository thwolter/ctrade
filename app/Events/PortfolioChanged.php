<?php

namespace App\Events;

use App\Entities\Portfolio;
use Carbon\Carbon;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PortfolioChanged
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $portfolio;
    public $timestamp;


    /**
     * Create a new event instance.
     *
     * @param Portfolio $portfolio
     * @param Carbon $timestamp
     *
     */
    public function __construct(Portfolio $portfolio, Carbon $timestamp)
    {
        $this->portfolio = $portfolio;
        $this->timestamp = $timestamp;
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
