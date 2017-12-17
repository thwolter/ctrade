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
    public function historiesByExchange($entity, $attributes = [])
    {
        $datasources = $this->getDatasource($entity, ['exchange' => '*']);

        $prices = [];
        foreach ($datasources as $datasource) {
            $prices[] = [
                'exchange' => $datasource->exchange->code,
                'data' => $this->priceHistory($datasource, $attributes),
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
     * @param $entity
     * @param array $attributes
     * @return mixed
     */
    public function priceHistory($entity, $attributes = [])
    {
        $datasource = $this->getDatasource($entity, $attributes);

        return $this->provider($datasource)->priceHistory($attributes);
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
        $datasource = $this->getDatasource($entity, $attributes);

        return $this->addMetaData(
            $this->provider($datasource)->dataHistory($attributes),
            $datasource
        );
    }


    public function statistics($entity, $attributes)
    {
        $prices = $this->priceHistory($entity, $attributes);
        return [
            'yearHigh' => max($prices),
            'yearLow' => min($prices),
            'yearReturn' => array_first($prices)/array_last($prices) - 1
        ];
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
    private function getDatasource($entity, $attributes)
    {
        $class = get_class($entity);
        if ($class === Datasource::class || $class === Collection::class) {
            return $entity;

        } else {
            $method = 'getDatasource' . class_basename(get_class($entity));
            return $this->$method($entity, $attributes);
        }
    }


    /**
     * Get the stock's datasource.
     *
     * @param Stock $stock
     * @param $all
     * @return mixed
     */
    private function getDatasourceStock($stock, $attributes)
    {
        switch (array_get($attributes, 'exchange')) {

            case '*':
                return $stock->datasources;
                break;

            case null:
                $exchanges = $exchanges = $stock->exchangesToArray();
                return $stock->getDatasource(array_get($exchanges, '0.code'));
                break;

            default:
                return $stock->datasources()->whereExchange($attributes['exchange'])->first();
                break;
        }
    }

}