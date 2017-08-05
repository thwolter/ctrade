<?php

namespace App\Notifications;

use App\Entities\Limit;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class LimitChanged extends Notification
{
    use Queueable;

    protected $limit;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Limit $limit)
    {
        $this->limit = $limit;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        if ($this->limit->active) {
            $present = [
                'title' => $this->limit->present()->type().' angepasst',
                'message' => 'Limit wurde auf '.$this->limit->present()->value().' gesetzt.',
            ];

        } else {
            $present = [
                'title' => $this->limit->present()->type().' deaktiviert',
                'message' => 'Limit wird nicht mehr überwacht.'
            ];
        }

        return array_merge($this->limit->toArray(), $present);
    }
}
