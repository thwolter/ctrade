<?php

namespace App\Classes\DataProvider;


trait TimeSeriesData
{

    /**
     * Wrapper for receiving the item's time series with data/count attributes.
     *
     * @param $item
     * @param $attributes
     * @return array
     */
    protected function timeSeries($item, $attributes)
    {
        if (array_has($attributes, ['from', 'to'])) {
            $timeSeries = $this->getTimeSeriesFromTo($item, $attributes['from'], $attributes['to']);

        } elseif (array_has($attributes, ['count'])) {
            $timeSeries = $this->getTimeSeriesDateCount($item, array_get($attributes, 'date'), $attributes['count']);

        } else {
            $timeSeries = $this->getTimeSeriesAllDates($item);
        }

        return [
            'columns' => $this->getColumnNames($item),
            'data' => $timeSeries
        ];
    }


    /**
     * Get the item's time series part between two dates.
     *
     * @param $item
     * @param $from
     * @param $to
     * @return array|mixed
     */
    protected function getTimeSeriesFromTo($item, $from, $to)
    {
        $timeSeries = $this->getTimeSeriesAllDates($item);

        return array_where($timeSeries, function ($value) use ($from, $to) {
            return $value[0] >= $from && $value[0] <= $to;
        });
    }


    /**
     * Get the item's time series part starting at the given date.
     *
     * @param $item
     * @param $date
     * @param $count
     * @return array
     */
    protected function getTimeSeriesDateCount($item, $date, $count)
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


    /**
     * Get the time series data of the item.
     *
     * @param $item
     * @return mixed
     */
    protected function getTimeSeriesAllDates($item)
    {
        return array_get($item, $this->fieldData);
    }


    /**
     * Get the data column names of the item.
     *
     * @param $item
     * @return mixed
     */
    protected function getColumnNames($item)
    {
        return array_get($item, $this->fieldColumnNames);
    }
}