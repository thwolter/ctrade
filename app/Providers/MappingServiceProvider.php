<?php


namespace App\Providers;


use App\Models\Mapping;
use Illuminate\Support\ServiceProvider;

class MappingServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('mapping', Mapping::class);
    }
}