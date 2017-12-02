<?php

namespace App\Notifications;

use App\Entities\Portfolio;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class RiskCalculated extends Notification
{
    use Queueable;

    protected $ratio;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($ratio)
    {
        $this->ratio = $ratio;
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
            'ratio' => $this->ratio,
        ]);
    }


}
