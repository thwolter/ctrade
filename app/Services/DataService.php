<?php


namespace App\Services;


use App\Classes\Output\Price;
use App\Classes\TimeSeries;
use App\Contracts\DataServiceInterface;
use App\Entities\Datasource;
use Illuminate\Database\Eloquent\Collection;


class DataService
{

    private $datasource;


    public function price($entity, $exchange = null)
    {
        $price = $this->history($entity, $exchange)->count(1)->getClose();

        return Price::fromArray($price, $entity->currency->code);

    }

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
     * Get the entity's datasource if entity is not yet a datasource or collection.
     *
     * @param $entity
     * @param string $exchange
     * @return mixed
     */
    public function getDatasource($entity, $exchange)
    {
        if ($this->isDatasource($entity)) return $entity;

        if (!$this->datasource) {
            $this->datasource = ($exchange === '*')
                ? $entity->datasources
                : $entity->getDatasource($this->exchange($entity, $exchange));
        }
        return $this->datasource;
    }


    /**
     * Return true if the given entity is already a datasource or collection.
     *
     * @param $entity
     * @return bool
     */
    private function isDatasource($entity)
    {
        $class = get_class($entity);
        return $class === Datasource::class || $class === Collection::class;
    }


    private function exchange($entity, $exchange)
    {
        return $exchange ?? $entity->exchangesToArray()[0]['code'];
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
     * Return the entity's price at a given date.
     *
     * @param $entity
     * @param $date
     * @param string|null $exchange
     *
     * @return float
     */
    public function priceAt($entity, $date, $exchange = null)
    {
        return array_first($this->history($entity, $exchange)->to($date)->count(1)->getClose());
    }
}