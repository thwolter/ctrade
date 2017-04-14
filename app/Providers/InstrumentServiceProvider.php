<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class InstrumentServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            'App\Repositories\Contracts\InstrumentInterface',
            'App\Repositories\InstrumentRepository'
        );
    }
}