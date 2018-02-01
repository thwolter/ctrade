<?php


namespace App\Classes;

use App\Exceptions\TimeSeriesException;
use Carbon\Carbon;


class TimeSeries
{

    /**
     * Time series data.
     *
     * @var array
     */
    private $data;

    /**
     * Columns names matching the column in the 'data' array.
     *
     * @var array|null
     */
    private $columns;

    /**
     * Filter elements used to prepare the data output.
     *
     * @var array
     */
    private $filter = [];


    /**
     * TimeSeries constructor.
     *
     * @param $data
     * @param null $columns
     */
    public function __construct($data, $columns = null)
    {
        $this->columns = $columns ? $columns : ['Value'];
        $this->data = array_is_multidimensional($data) ? $this->normalize($data) : $data;
    }

    /**
     * Make an associative array with dates as key.
     *
     * @param $data
     * @return array
     */
    private function normalize($data)
    {
        if ($this->isDate(key($data))) {
            return array_combine(array_keys($data), array_flatten($data));

        } else {
            return array_combine(array_column($data, $this->getColumn('Date')), $data);
        }
    }

    private function isDate($string)
    {
        try {
            $date = Carbon::createFromFormat('Y-m-d', $string);

        } catch (\Exception $exception) {
            return false;
        }

        return $date->toDateString() === $string;
    }

    /**
     * Get the specified column out of the data.
     *
     * @param $column
     * @return false|int|string
     */
    private function getColumn($column)
    {
        return array_search($column, $this->columns);
    }

    /**
     * Dynamic handling of getters for time series columns.
     *
     * @param $name
     * @param $arguments
     * @return array
     *
     * @throws TimeSeriesException
     */
    public function __call($name, $arguments)
    {
        if ($field = $this->tryGet($name)) {
            return $this->column($field)->get();
        }

        if ($field = $this->tryGetLatest($name)) {
            return $this->column($field)->count(1)->get();
        }

        if ($field = $this->tryGetOldest($name)) {
            return $this->column($field)->reverse()->count(1)->get();
        }

        $this->throwException($name, $field);

    }

    /**
     * @param $name
     * @return array|boolean
     */
    private function tryGet($name)
    {
        $field = str_replace('get', null, $name);
        return array_search($field, $this->columns) ? $field : false;

    }

    /**
     * Method is called to prepare and receive time series data as array.
     *
     * @return array|mixed
     * @throws TimeSeriesException
     */
    public function get()
    {
        if (!count($this->filter)) {
            throw new TimeSeriesException('Filter must be set for multidimensional TimeSeries.');
        }

        $data = $this->fillDates($this->data);
        $data = $this->sortByDates($data);
        $data = $this->filterByDates($data);

        $data = $this->filtercolumn($data);
        $data = $this->toReverse($data);

        $data = $this->setToCount($data);
        $data = $this->reduceToLimit($data);

        $this->filter = [];
        return $data;
    }

    /**
     * Fill required dates with values from previous day.
     *
     * @param $data
     * @return array
     */
    private function fillDates($data)
    {
        if (array_has($this->filter, ['from', 'to', 'fill'])) {

            $current = Carbon::parse($this->filter['from']);
            while (Carbon::parse($this->filter['to'])->diffInDays($current, false) < 0) {
                $yesterday = $current->copy()->subDay();
                $data = array_add($data, $current->format('Y-m-d'), $data[$yesterday->format('Y-m-d')]);
                $current->addDay();
            }
        }
        return $this->sortByDates($data);
    }

    /**
     * Sort data by dates.
     *
     * @param $data
     * @return mixed
     */
    private function sortByDates($data)
    {
        krsort($data);
        return $data;
    }

    /**
     * Adopt the dates filter to limit the returned data.
     * @param $data
     * @return array
     */
    private function filterByDates($data)
    {
        $filter = $this->filter;
        $days = array_get($this->filter, 'days');

        $output = array_filter($data, function ($key) use ($filter, $days) {

            $check = [true];
            $date = Carbon::parse($key);

            if (array_has($filter, ['to']))
                $check[] = $date->diffInDays(Carbon::parse(array_get($filter, 'to')), false) >= 0;

            if (array_has($filter, ['from']))
                $check[] = $date->diffInDays(Carbon::parse(array_get($filter, 'from')), false) <= 0;

            if ($days)
                $check[] = Carbon::parse($key)->$days();

            return (count(array_unique($check)) === 1) ? current($check) : false;

        }, ARRAY_FILTER_USE_KEY);

        return $output;
    }

    /**
     * Filter by columns specified in the filter settings.
     *
     * @param $data
     * @return array
     */
    private function filterColumn($data)
    {
        $key = $this->getColumn(array_get($this->filter, 'column'));

        if (!array_is_multidimensional($data)) {
            $filteredData = $data;

        } elseif ($key) {
            $filteredData = array_column($data, $key, $this->getColumn('Date'));

        } else {
            $filteredData = array_combine(
                array_keys($data),
                array_fill(0, count($data), null)
            );
        }
        return $filteredData;
    }

    /**
     * @param $data
     * @return array
     */
    private function toReverse($data)
    {
        $reverse = array_get($this->filter, 'reverse', false);

        return $reverse ? array_reverse($data) : $data;
    }

    /**
     * @param $data
     * @return array
     */
    private function setToCount($data)
    {
        $count = (int)array_get($this->filter, 'count');

        if ($count) {
            $data = array_slice($data, 0, $count, true);
            return count($data) === $count ? $data : [];

        } else {
            return $data;
        }
    }

    private function reduceToLimit($data)
    {
        $limit = (int)array_get($this->filter, 'limit');

        return $limit ? array_slice($data, 0, $limit) : $data;
    }

    /**
     * Specify the column of the data to be returned.
     *
     * @param $column
     * @return $this
     */
    public function column($column)
    {
        array_set($this->filter, 'column', $column);
        return $this;
    }

    /**
     * @param $name
     * @return array|boolean
     */
    private function tryGetLatest($name)
    {
        $field = str_replace('getLatest', null, $name);
        return array_search($field, $this->columns) ? $field : false;
    }

    /**
     * Number of data to be returned.
     *
     * @param $count
     * @return $this
     */
    public function count($count)
    {
        array_set($this->filter, 'count', $count);
        return $this;
    }

    /**
     * @param $name
     * @return array|boolean
     */
    private function tryGetOldest($name)
    {
        $field = str_replace('getOldest', null, $name);
        return array_search($field, $this->columns) ? $field : false;
    }

    public function reverse()
    {
        array_set($this->filter, 'reverse', true);
        return $this;
    }

    /**
     * @param $name
     * @param $field
     * @throws TimeSeriesException
     */
    private function throwException($name, $field): void
    {
        $message = substr($name, 0, 3) === 'get'
            ? "Column $field not known."
            : "No property $name available.";

        throw new TimeSeriesException($message);
    }

    public function limit($limit)
    {
        array_set($this->filter, 'limit', $limit);
        return $this;
    }

    /**
     * Starting date of the data to be returned.
     *
     * @param $date
     * @return $this
     */
    public function from($date)
    {
        array_set($this->filter, 'from', $date);
        return $this;
    }

    /**
     * End date of the data to be returned.
     *
     * @param $date
     * @return $this
     */
    public function to($date)
    {
        array_set($this->filter, 'to', $date);
        return $this;
    }

    /**
     * Defines wether only the weekday shall be returned.
     *
     * @return $this
     */
    public function weekdays()
    {
        array_set($this->filter, 'days', 'isWeekday');
        return $this;
    }

    /**
     * Fill the data to be returned between 'from' and 'to' date. The
     * 'type' is not yet evaluated to specify the approach how to fill not available data.
     *
     * @param $type
     * @return $this
     */
    public function fill($type)
    {
        array_set($this->filter, 'fill', $type);
        return $this;
    }

    public function asAssocArray()
    {
        array_set($this->filter, 'assoc', true);
        return $this;
    }

}