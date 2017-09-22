<?php


namespace App\Providers;


use App\Entities\Datasource;
use App\Repositories\DatasourceRepository;
use Illuminate\Support\ServiceProvider;

class DatasourceServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('datasource', Datasource::class);
    }
}