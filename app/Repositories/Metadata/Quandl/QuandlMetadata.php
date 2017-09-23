<?php

namespace App\Repositories\Metadata\Quandl;

use App\Repositories\Metadata\BaseMetadata;
use Carbon\Carbon;
use Quandl;

abstract class QuandlMetadata extends BaseMetadata
{

    protected $provider = 'Quandl';
    protected $queue = 'quandl';

    protected $perPage;
    protected $nextPage = 0;
    protected $totalPages = 2;

    protected $columns = [
        //
    ];



    public function getFirstItems()
    {
        $this->nextPage = 0;
        return $this->getNextItems($this->chunk);

    }

    public function getNextItems()
    {
        if (is_null($this->nextPage)) return [];

        $json = $this->client->getList($this->database, $this->nextPage, $this->chunk);
        $array = json_decode($json, true);

        $this->nextPage = array_get($array, 'meta.next_page');
        $this->totalPages = array_get($array, 'meta.total_pages');

        return $array['datasets'];
    }



    public function dataset($item)
    {
        return $this->symbol($item);
    }


    /**
     * Return the timeSeries with columns specified for this class in array $columns.
     *
     * @param $item
     * @param $attributes
     * @return array
     */
    public function withColumns($item, $attributes)
    {
        $timeSeries = $this->timeSeries($item, $attributes);

        $array = [];
        for ($i = 0; $i < count($timeSeries); $i++) {
            $array[] = $this->array_columns($timeSeries[$i], $this->columnNames($item));
        }

        return [
            'columns' => array_keys($this->columns),
            'data' => $array
        ];
    }


    public function timeSeries($item, $attributes)
    {
        if (array_has($attributes, ['from', 'to'])) {
            return $this->getTimeSeriesFromTo($item, $attributes['from'], $attributes['to']);

        } elseif (array_has($attributes, ['count'])) {
            return $this->getTimeSeriesDateCount($item, array_get($attributes, 'date'), $attributes['count']);

        } else {
            return $this->getTimeSeriesAllDates($item);
        }
    }


    private function getTimeSeriesFromTo($item, $from, $to)
    {
        $timeSeries = $this->getTimeSeriesAllDates($item);

        return array_where($timeSeries, function ($value) use ($from, $to) {
            return $value[0] >= $from && $value[0] <= $to;
        });
    }


    private function getTimeSeriesDateCount($item, $date, $count)
    {
        $timeSeries = $this->getTimeSeriesAllDates($item);

        if ($date) {
            $result = array_where($timeSeries, function ($value) use ($date) {
                return $value[0] <= $date;
            });

        } else {
            $result = $timeSeries;
        }

        return array_slice($result, 0, $count);
    }


    private function getTimeSeriesAllDates($item)
    {
        return array_get($item, 'dataset.data');
    }



    public function refreshed($item)
    {
        return Carbon::parse(array_get($item, 'refreshed_at'));
    }


    public function newestPrice($item)
    {
        return Carbon::parse(array_get($item, 'newest_available_date'));
    }


    public function oldestPrice($item)
    {
        return Carbon::parse(array_get($item, 'oldest_available_date'));
    }


    /**
     * Fetch details for a given symbol from the provider's database.
     *
     * @param $symbol
     * @return mixed
     */
    public function getSymbol($symbol)
    {
        $item = $this->client->getSymbol($this->database . '/' . $symbol);
        return array_get(json_decode($item, true), 'dataset');
    }


    public function columnNames($item)
    {
        return array_get($item, 'dataset.column_names');
    }


    /**
     * Returns the specified columns of an array.
     *
     * @param array $array of column names
     * @param array $columns
     * @return array
     */
    private function array_columns($array, $columns)
    {
        $row = [];
        foreach ($this->columns as $key => $value) {
            $row[] = $array[array_index($value, $columns)];
        }
        return $row;
    }

}