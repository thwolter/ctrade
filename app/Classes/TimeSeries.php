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
     * Temporary output variable used for storing result while processing filtering.
     *
     * @var array
     */
    private $output;

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

    /**
     * Returns true, if the string can be converted to a date.
     *
     * @param $string
     * @return bool
     */
    private function isDate($string)
    {
        try {
            $date = Carbon::parse($string);

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

        $this->initiateOutput();
        $this->fillDates();
        $this->sortByDates();

        $this->filterDateFrom();
        $this->filterDateTo();
        $this->filterByDays();

        $this->toReverse();

        $this->setToCount();
        $this->reduceToLimit();

        $this->toAssocArray();
        $this->filtercolumn();

        $this->resetFilter();
        return $this->output;
    }

    /**
     * Delete the output variable.
     */
    private function initiateOutput()
    {
        $this->output = $this->data;
    }

    /**
     * Fill required dates with values from previous day.
     *
     * @return void
     * @throws TimeSeriesException
     */
    private function fillDates()
    {
        $data = $this->output;
        if (!$this->checkShouldFill()) return null;

        $current = $this->filter['from']->copy();
        while ($this->filter['to']->diffInDays($current, false) <= 0) {

            $key = $current->toDateString();
            if (!array_has($data, $key)) {

                $previous = $data[$this->lastDateBefore($data, $current)];
                $previous[$this->getColumn('Date')] = $key;

                $data = array_add($data, $key, $previous);
            }
            $current->addDay();
        }

        $this->output = $data;
    }

    /**
     * @return boolean
     * @throws TimeSeriesException
     */
    private function checkShouldFill()
    {
        if (!array_has($this->filter, 'fill')) return false;

        if (!array_has($this->filter, ['from', 'to'])) {
            throw new TimeSeriesException("'fill' requires dates 'from' and 'to'.");
        }

        return true;

    }

    /**
     * @param $data
     * @param $date
     * @return string
     * @throws TimeSeriesException
     */
    private function lastDateBefore($data, $date)
    {
        $result = array_first(array_filter(array_keys($data), function ($day) use ($date) {
            return Carbon::parse($day)->diffInDays($date, false) > 0;
        }));

        if (!$result) {
            throw new TimeSeriesException("No data available before $date");
        }

        return $result;
    }

    /**
     * Sort data by dates.
     *
     * @return void
     */
    private function sortByDates()
    {
        krsort($this->output);
    }

    /**
     * Reduce output variable to dates starting from a given date.
     *
     * @return array
     */
    private function filterDateFrom()
    {
        $data = $this->output;

        $from = array_get($this->filter, 'from');
        if (!$from) return $data;

        $this->output = array_filter($data, function ($key) use ($from) {
            return Carbon::parse($key)->diffInDays($from, false) <= 0;
        }, ARRAY_FILTER_USE_KEY);
    }

    /**
     * @return void
     */
    private function filterDateTo()
    {
        $to = array_get($this->filter, 'to');

        if ($to) {
            $this->output = array_filter($this->output, function ($key) use ($to) {
                return Carbon::parse($key)->diffInDays($to, false) >= 0;
            }, ARRAY_FILTER_USE_KEY);
        }
    }

    /**
     * Adopt the dates filter to limit the returned data.
     *
     * @return void
     */
    private function filterByDays()
    {
        $days = array_get($this->filter, 'days');

        if ($days) {
            $this->output = array_filter($this->output, function ($key) use ($days) {
                return Carbon::parse($key)->$days();
            }, ARRAY_FILTER_USE_KEY);
        }
    }

    /**
     * @return void
     */
    private function toReverse()
    {
        if (array_get($this->filter, 'reverse')) {
            $this->output = array_reverse($this->output);
        }
    }

    /**
     * @return void
     */
    private function setToCount()
    {
        $count = (int)array_get($this->filter, 'count');

        if ($count) {
            $data = array_slice($this->output, 0, $count, true);
            $this->output = count($data) === $count ? $data : [];
        }
    }

    private function reduceToLimit()
    {
        $limit = (int)array_get($this->filter, 'limit');

        if ($limit) {
            $this->output = array_slice($this->output, 0, $limit);
        }
    }

    /**
     *
     */
    private function toAssocArray()
    {
        if (array_get($this->filter, 'assoc')) {

            foreach ($this->output as $key => $row) {
                $this->output[$key] = array_combine($this->columns, $row);
            }
        }
    }

    /**
     * Filter by columns specified in the filter settings.
     *
     * @return void
     */
    private function filterColumn()
    {
        if (!array_is_multidimensional($this->output)) return null;

        if (array_get($this->filter, 'assoc')) {
            $this->filterAssocArrayColumn();

        } else {
            $this->filterPlainArrayColumn();
        }
    }

    private function filterAssocArrayColumn()
    {
        $key = array_get($this->filter, 'column');

        if ($key) {
            $this->output = array_map(function ($value) use ($key) {
                return [$key => $value[$key]];
            }, $this->output);
        }
    }

    private function filterPlainArrayColumn()
    {
        $key = $this->getColumn(array_get($this->filter, 'column'));
        $this->output = array_column($this->output, $key, $this->getColumn('Date'));
    }

    public function resetFilter()
    {
        $this->filter = [];
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
        array_set($this->filter, 'from', Carbon::parse($date));
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
        array_set($this->filter, 'to', Carbon::parse($date));
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
    public function fill($type = '')
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