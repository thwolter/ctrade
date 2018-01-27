<?php

namespace App\Notifications;

use App\Jobs\Calculations\CalculationObject;
use App\Jobs\Calculations\Joblet;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class StatusCalculation extends Notification
{
    use Queueable;


    private $joblet;
    private $remainder;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Joblet $joblet, $remainder)
    {
        $this->joblet = $joblet;
        $this->remainder = $remainder;
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
            'portfolio_id' => $this->joblet->portfolio->id,
            'metric' => $this->joblet->metric,
            'total' => $this->joblet->total,
            'remainder' => $this->remainder
        ]);
    }
}
