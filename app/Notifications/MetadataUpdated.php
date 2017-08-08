<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class MetadataUpdated extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
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

       /* $providerId = Provider::whereCode($event->provider)->first()->id;
        $databaseId = Database::whereCode($event->database)->first()->id;
        $datasources = Datasource::whereProviderId($providerId)->whereDatabaseId($databaseId);

        \Mail::to(env('MAIL_ADMIN'))->send(new MetadataUpdated([
                'provider' => $event->provider,
                'database' => $event->database,
                'created' => $event->created,
                'updated' => $event->updated,
                'invalidated' => $event->invalidated,
                'validated' => $event->validated,
                'total' => $datasources->count(),
                'valid' => $datasources->whereValid(true)->count()
            ]
        ));*/
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
