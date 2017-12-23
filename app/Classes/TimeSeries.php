<?php


namespace App\Classes;

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
     * Dynamic handling of getters for time series columns.
     *
     * @param $name
     * @param $arguments
     * @return array|mixed
     */
    public function __call($name, $arguments)
    {
        if (substr($name, 0, 3) === 'get') {
            $field = str_replace('get', null, $name);

            return $this->column($field)->get();
        }
    }


    /**
     * Method is called to prepare and receive time series data as array.
     *
     * @return array|mixed
     */
    public function get()
    {
        $data = $this->fillDates($this->data);
        $data = $this->sortByDates($data);

        $data = $this->filterByDates($data);

        $data = $this->filtercolumn(
            array_slice($data, 0, array_get($this->filter, 'count'))
        );

        if (array_get($this->filter, 'reverse', false))
            $data = array_reverse($data);

        $this->filter = [];
        return $data;
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


    public function reverse()
    {
        array_set($this->filter, 'reverse', true);
        return $this;
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

            if (array_has($filter,['to']))
                $check[] = $date->diffInDays(Carbon::parse(array_get($filter, 'to')), false) >= 0;

            if (array_has($filter,['from']))
                $check[] = $date->diffInDays(Carbon::parse(array_get($filter, 'from')), false) <= 0;

            if ($days)
                $check[] = Carbon::parse($key)->$days();

            return (count(array_unique($check)) === 1) ? current($check) : false;

        }, ARRAY_FILTER_USE_KEY);

        return $output;
    }


    private function isDate($string)
    {
        try {
            $date = Carbon::createFromFormat('Y-m-d', $string);

        } catch(\Exception $exception) {
            return false;
        }

        return $date->toDateString() === $string;
    }

}