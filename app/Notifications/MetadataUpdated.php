<?php

namespace App\Notifications;

use App\Entities\Datasource;
use App\Repositories\DatasourceRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class MetadataUpdated extends Notification
{
    use Queueable;

    protected $provider;
    protected $database;


    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($provider, $database)
    {
        $this->provider = $provider;
        $this->database = $database;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Metadata updated.')
            ->markdown('emails.metadata.updated', [
                'results' => $this->toArray($notifiable)
            ]);
    }


    /**
     * Get the array representation of the notification.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $datasources = Datasource::whereOrigin($this->provider, $this->database);

        return [
            'provider' => $this->provider,
            'database' => $this->database,
            'total' => $datasources->count(),
            'valid' => $datasources->valid()->count(),
        ];
    }
}
