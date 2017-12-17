<?php

namespace App\Classes\DataProvider;

use App\Contracts\DataServiceInterface;
use App\Entities\Datasource;
use App\Events\PriceData\FetchingFailed;
use App\Exceptions\DataServiceException;
use App\Models\PriceHistory;
use Illuminate\Support\Facades\Log;

class QuandlPriceData implements DataServiceInterface
{
    use TimeSeriesData, FetchQuandlData;


    protected $datasource;

    protected $client;

    protected $fieldColumnNames = 'dataset.column_names';

    protected $fieldData = 'dataset.data';

    protected $priceColumnNames = ['Close'];



    public function __construct(Datasource $datasource)
    {
        $this->datasource = $datasource;
        $this->client = app()->make('QuandlClient');
    }


    /**
     * Get the item's latest price.
     *
     * @param null $date
     * @return array
     * @throws DataServiceException
     */
    public function price($date = null)
    {
        return $this->getPriceHistory()->price($date);
    }


    /**
     * Return an array with the history of close prices of an item.
     *
     * @param array $attributes
     * @return array|mixed
     * @throws DataServiceException
     * @throws \Exception
     */
    public function priceHistory($attributes = [])
    {
        return $this->getPriceHistory($attributes)->history($attributes);
    }


    /**
     * Returns an nested array with column names and prices history.
     *
     * @param $attributes
     * @return array
     * @throws DataServiceException
     */
    public function dataHistory($attributes)
    {
        $item = json_decode($this->getJson(), true);

        return $this->timeSeries($item, $attributes);
    }


    /**
     * Get the item's price history.
     *
     * @return PriceHistory
     * @throws DataServiceException
     */
    private function getPriceHistory($attributes = [])
    {
        $data =  $this->dataHistory($attributes);

        return new PriceHistory($data['data'], $this->priceColumn($data['columns']));
    }


    /**
     * Find the item's price column based on set priceColumnNames array.
     *
     * @param $columnNames
     * @return false|int|string
     */
    private function priceColumn($columnNames)
    {
        $i = 0;
        $count = count($this->priceColumnNames);

        while (!isset($column) and $i < $count) {
            $column = array_search($this->priceColumnNames[$i++], $columnNames);
        }

        return ($column) ? $column : 1;
    }


}