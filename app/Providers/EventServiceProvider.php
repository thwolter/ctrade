<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
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

        /*
         * Metadata events
         */
        'App\Events\MetadataUpdateHasStarted' => [
            'App\Listeners\Metadata\NotifyUpdatedHasStarted'
        ],
        'App\Events\MetadataUpdateHasCanceled' => [
            'App\Listeners\Metadata\NotifyUpdatedHasCanceled'
        ],
        'App\Events\MetadataUpdateHasFinished' => [
            'App\Listeners\Metadata\NotifyUpdatedHasFinished',
            'App\Listeners\Overall\UpdateRiskCalculations',
            'App\Listeners\Overall\UpdateValueCalculations',
        ],

        /*
         * Portfolio events
         */
        'App\Events\PortfolioHasChanged' => [
            'App\Listeners\Portfolio\CalculatePortfolioRisk',
            'App\Listeners\Portfolio\CalculatePortfolioValue'
        ],

        /*
         * Limit events
         */
        'App\Events\Limits\LimitHasChanged' => [
            'App\Listeners\Limit\NotifyLimitHasChanged',
            'App\Listeners\Limit\CheckLimit'
        ],
        'App\Events\Limits\LimitHasBreached' => [
            'App\Listeners\Limit\NotifyLimitHasBreached'
        ],

        /*
         * Price data events
         */
        'App\Events\PriceData\FetchingFailed' => [
            'App\Listeners\PriceData\NotifyFetchingFailed'
        ],

        /*
         * Calculation events
         */
        'App\Events\PortfolioRiskWasCalculated' => [
            'App\Listeners\Portfolio\RecalculateUtilisation'
        ],
        'App\Events\PortfolioValueWasCalculated' => [
            'App\Listeners\Portfolio\RecalculateUtilisation'
        ],

        /*
         * Email verification events
         */
        'App\Events\Verification\EmailHasChanged' => [
            'App\Listeners\Verification\SendNewEmailVerificationReminder'
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
