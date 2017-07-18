<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\MetadataUpdateHasStarted' => [
            'App\Listeners\NotifyMetadataUpdatedHasStarted'
        ],
        'App\Events\MetadataUpdateHasFinished' => [
            'App\Listeners\NotifyMetadataUpdatedHasFinished'
        ],
        'App\Events\PortfolioChanged' => [
            'App\Listeners\CalculatePortfolioRisk'
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
