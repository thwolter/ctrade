<?php


namespace App\Entities\Traits;


use Illuminate\Support\Facades\Cache;

trait CacheDatasource
{

    public function cacheKey($name)
    {
        return sprintf(
                "%s/%s-%s",
                $this->getTable(),
                $this->getKey(),
                $this->updated_at->timestamp
            ) . ':' . $name;
    }

    public function getDatasource($exchange)
    {
        return Cache::remember($this->cacheKey('exchange_datasource'), 15, function () use ($exchange) {
            return $this->datasources()->whereExchange($exchange)->first();
        });
    }

    public function getCachedDatasourcesAttribute()
    {
        return Cache::remember($this->cacheKey('datasources'), 15, function () {
            return $this->datasources;
        });
    }
}