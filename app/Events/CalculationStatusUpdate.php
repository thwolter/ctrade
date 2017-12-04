<?php

namespace App\Events;

use App\Jobs\Calculations\CalculationObject;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CalculationStatusUpdate implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $calculation;


    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(CalculationObject $calculation)
    {
        $this->calculation = $calculation;
    }


    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('portfolio.'.$this->calculation->getPortfolio()->id);
    }


    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith()
    {
        return [
            'metric' => $this->calculation->getType(),
            'total' => $this->calculation->total(),
            'remainder' => $this->calculation->remainder()
        ];
    }
}
