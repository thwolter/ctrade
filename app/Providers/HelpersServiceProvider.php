<?php

namespace App\Providers;

use App\Helpers\TimeSeries;
use Illuminate\Support\ServiceProvider;


class HelpersServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('TimeSeries', TimeSeries::class);
    }
}