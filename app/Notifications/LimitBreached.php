<?php

namespace App\Notifications;

use App\Entities\Limit;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class LimitBreached extends Notification
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
        $value = $this->limit->present()->value();
        $type = $this->limit->present()->type();
        $portfolio = $this->limit->portfolio->name;
        $date = $this->limit->present()->date();
        $risk = $this->limit->portfolio->present()->risk();

        $present = [
            'title' => "$type überschritten",
            'message' => "Limit ($value) für Portfolio $portfolio verletzt (Risiko: $risk)"
        ];

        return array_merge($this->limit->toArray(), $present);
    }
}
