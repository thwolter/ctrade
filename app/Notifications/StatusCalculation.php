<?php

namespace App\Notifications;

use App\Jobs\Calculations\CalculationObject;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class StatusCalculation extends Notification
{
    use Queueable;

    protected $calculation;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(CalculationObject $calculation)
    {
        $this->calculation = $calculation;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['broadcast'];
    }

    /**
     * Get the broadcastable representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return BroadcastMessage
     */
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'pid' => $this->calculation->getPortfolio()->id,
            'metric' => $this->calculation->getType(),
            'total' => $this->calculation->total(),
            'remainder' => $this->calculation->remainder()
        ]);
    }
}
