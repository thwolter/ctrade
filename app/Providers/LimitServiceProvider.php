<?php

namespace App\Providers;

use App\Entities\Limit;
use App\Classes\Limits\AbstractLimit;
use App\Services\LimitService;
use Illuminate\Support\ServiceProvider;

class LimitServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(AbstractLimit::class, function ($app, $parameter)
        {
            $limit = $parameter[0];

            throw_if(get_class($limit) !== Limit::class,
                "Class {Limit::class} required.");

            $type = ucfirst(camel_case($limit->type));

            return $this->app
                ->makeWith("App\Classes\Limits\\{$type}Limit", ['limit' => $limit]);
        });

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('limitService', LimitService::class);
    }
}
