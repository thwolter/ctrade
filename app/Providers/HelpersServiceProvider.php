<?php

namespace App\Providers;

use App\Classes\Helpers;
use Illuminate\Support\ServiceProvider;


class HelpersServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('helpers', Helpers::class);
    }
}