<?php


namespace App\Services;


use App\Classes\TimeSeries;
use App\Contracts\DataServiceInterface;
use App\Entities\Datasource;
use Illuminate\Database\Eloquent\Collection;


class DataService
{

    /**
     * Return a TimeSeries Object for chosen entity and exchange.
     *
     * @param $entity
     * @param null $exchange
     * @return TimeSeries
     */
    public function history($entity, $exchange = null)
    {
        $datasource = $this->getDatasource($entity, $exchange);

        return $this->provider($datasource)->history();
    }


    /**
     * Get the datasource provider.
     *
     * @param $datasource
     * @return DataServiceInterface|\Illuminate\Foundation\Application|mixed
     */
    private function provider($datasource)
    {
        return app(DataServiceInterface::class, [$datasource]);
    }


    /**
     * Get the entity's datasource if entity is not yet a datasource or collection.
     *
     * @param $entity
     * @param $attributes
     * @return mixed
     */
    public function getDatasource($entity, $exchange)
    {
        $class = get_class($entity);
        if ($class === Datasource::class || $class === Collection::class) {
            return $entity;

        } else {
            $method = 'getDatasource' . class_basename(get_class($entity));
            return $this->$method($entity, $exchange);
        }
    }


    /**
     * Get the stock's datasource.
     *
     * @param $entity
     * @param string $exchange
     * @return mixed
     */
    private function getDatasourceStock($entity, $exchange)
    {
        switch ($exchange) {

            case '*':
                return $entity->datasources;
                break;

            case null:
                $exchanges = $exchanges = $entity->exchangesToArray();
                return $entity->getDatasource(array_get($exchanges, '0.code'));
                break;

            default:
                return $entity->datasources()->whereExchange($exchange)->first();
                break;
        }
    }

}