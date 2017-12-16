<?php


namespace App\Services;


use App\Contracts\DataServiceInterface;
use App\Entities\Datasource;
use Illuminate\Database\Eloquent\Collection;


class DataService implements DataServiceInterface
{

    /**
     * Return the entity's price histories for all exchanges.
     *
     * @param $datasources
     * @return array
     */
    public function historiesByExchange($entity)
    {
        $datasources = $this->getDatasource($entity, true);

        $prices = [];
        foreach ($datasources as $datasource) {
            $prices[] = [
                'exchange' => $datasource->exchange->code,
                'data' => $this->priceHistory($datasource),
                'datasourceId' => $datasource->id];
        };
        return $prices;
    }


    public function price($datasource, $date = null)
    {
        return $this->provider($datasource)->price($date);
    }


    /**
     * Return the history of a datasource's prices as array with dates as key.
     *
     * @param $datasource
     * @param null $dates
     * @return mixed
     */
    public function priceHistory($datasource, $dates = null)
    {
        return $this->provider($datasource)->priceHistory($dates);
    }


    /**
     * Return the complete dataset of the entity's history with opening, closing prices, etc.
     *
     * @param $entity
     * @param null $attributes
     * @return array
     */
    public function dataHistory($entity, $attributes = null)
    {
        $datasource = $this->getDatasource($entity);

        return $this->addMetaData(
            $this->provider($datasource)->dataHistory($attributes),
            $datasource
        );
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
     * Add somme Metadata to the output.
     *
     * @param $array
     * @param $datasource
     * @return array
     */
    private function addMetaData($array, $datasource)
    {
        return array_merge($array, [
            'currency' => $datasource->currency->code,
            'exchange' => $datasource->exchange->code,
            'datasource_id' => $datasource->id
        ]);
    }


    /**
     * Get the entity's datasource if entity is not yet a datasource or collection.
     *
     * @param $entity
     * @param bool $all
     * @return mixed
     */
    private function getDatasource($entity, $all = false)
    {
        $class = get_class($entity);
        if ($class === Datasource::class || $class === Collection::class) {
            return $entity;

        } else {
            $method = 'getDatasource' . class_basename(get_class($entity));
            return $this->$method($entity, $all);
        }
    }


    /**
     * Get the stock's datasource.
     *
     * @param Stock $stock
     * @param $all
     * @return mixed
     */
    private function getDatasourceStock($stock, $all)
    {
        $exchanges = $stock->exchangesToArray();
        return $all
            ? $stock->datasources
            : $stock->getDatasource(array_get($exchanges, '0.code'));
    }

}