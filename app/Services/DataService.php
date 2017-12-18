<?php


namespace App\Services;


use App\Contracts\DataServiceInterface;
use App\Entities\Datasource;
use App\Entities\Stock;
use Illuminate\Database\Eloquent\Collection;


class DataService
{


    public function history($entity, $exchange = null)
    {
        $datasource = $this->getDatasource($entity, ['exchange' => $exchange]);

        return $this->provider($datasource)->history();
    }


    /**
     * Return the entity's price histories for all exchanges.
     *
     * @param $attributes
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


    /**
     * Return the history of a datasource's prices as array with dates as key.
     *
     * @param $entity
     * @param array $attributes
     * @return mixed
     */
    public function priceHistory($entity, $attributes = [])
    {
        return $this->history($entity)
            ->count(array_get($attributes, 'count'))
            ->from(array_get($attributes, 'from'))
            ->to(array_get($attributes, 'to'))
            ->dates(array_get($attributes, 'dates'))
            ->column('Close')
            ->get();
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
        $data = $this->history($entity, array_get($attributes, 'exchange'));

        return $this->addMetaData([
            'data' => array_values($data->getData()),
            'columns' => $data->getColumns()
        ], $this->getDatasource($entity, $attributes));

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
     * @param $attributes
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
     * @param $stock
     * @param $attributes
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