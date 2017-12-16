<?php


namespace App\Services;


use App\Contracts\DataServiceInterface;


class DataService implements DataServiceInterface
{

    /**
     * @param $datasources
     * @return array
     */
    public function historiesByExchange($datasources)
    {
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


    public function priceHistory($datasource, $dates = null)
    {
        return $this->provider($datasource)->priceHistory($dates);
    }


    public function dataHistory($datasource, $attributes = null)
    {
        return $this->addMetaData(
            $this->provider($datasource)->dataHistory($attributes),
            $datasource
        );
    }


    private function provider($datasource)
    {
        return app(DataServiceInterface::class, [$datasource]);
    }


    private function addMetaData($array, $datasource)
    {
        return array_merge($array, [
            'currency' => $datasource->currency->code,
            'exchange' => $datasource->exchange->code,
            'datasource_id' => $datasource->id
        ]);
    }


}