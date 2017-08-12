<?php

namespace App\Notifications;

use App\Entities\Limit;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
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
        return ['broadcast', 'database'];
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
     * Get the broadcastable representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return BroadcastMessage
     */
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $value = $this->limit->present()->value();
        $type = $this->limit->present()->type();
        $portfolio = $this->limit->portfolio->name;
        $date = $this->limit->present()->date();

        $message = ($date)
            ? "Neues Limit für Portfolio $portfolio ist $value bis $date"
            : "Neues Limit für Portfolio $portfolio ist $value.";

        if ($this->limit->active) {
            $present = [
                'title' => "$type angepasst",
                'message' => $message,
            ];

        } else {
            $present = [
                'title' => "$type deaktiviert",
                'message' => "Limit für Portfolio $portfolio wird nicht mehr überwacht."
            ];
        }

        return array_merge($this->limit->toArray(), $present);
    }
}
