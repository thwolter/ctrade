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
            'App\Listeners\Metadata\NotifyUpdatedHasStarted'
        ],
        'App\Events\MetadataUpdateHasCanceled' => [

        ],
        'App\Events\MetadataUpdateHasFinished' => [
            'App\Listeners\Metadata\NotifyUpdatedHasFinished',
            'App\Listeners\Overall\UpdateRiskCalculations',
            'App\Listeners\Overall\UpdateValueCalculations',
        ],
        'App\Events\PortfolioHasChanged' => [
            'App\Listeners\Portfolio\CalculatePortfolioRisk',
            'App\Listeners\Portfolio\CalculatePortfolioValue'
        ],
        'App\Events\LimitHasChanged' => [
            'App\Listeners\Limit\NotifyLimitHasChanged',
            'App\Listeners\Limit\CheckLimit'
        ],
        'App\Events\LimitHasBreached' => [
            'App\Listeners\Limit\NotifyLimitHasBreached'
        ],
        'App\Events\PortfolioRiskWasCalculated' => [
            'App\Listeners\Portfolio\RecalculateUtilisation'
        ],
        'App\Events\PortfolioValueWasCalculated' => [
            'App\Listeners\Portfolio\RecalculateUtilisation'
        ]
    ];


    /**
     * The subscriber classes to register.
     *
     * @var array
     */
    protected $subscribe = [

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
