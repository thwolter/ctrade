<?php


namespace App\Classes;

use Carbon\Carbon;


class TimeSeries
{

    private $data;

    private $columns;

    private $exchange;

    private $output;



    public function __construct($attributes)
    {
        $this->columns = $attributes['columns'];
        $this->data = $this->normalize($attributes['data']);

        $this->exchange = array_get($attributes, 'exchange');
    }

    public function get()
    {
        $output = array_is_multidimensional($this->output) ? $this->column('Close')->output : $this->output;

        $this->output = null;
        return $output;
    }


    public function count($count = null)
    {
        if ($count)
            $this->output = array_slice($this->output(), 0, $count);

        return $this;
    }

    public function from($date = null)
    {
        return $this;
    }

    public function to($date = null)
    {
        return $this;
    }


    public function column($column = null)
    {
        if ($column)
            $this->output = array_column($this->output(), $this->getColumn($column), $this->getColumn('Date'));

        return $this;
    }


    public function dates($dates = null)
    {
        if ($dates)
            $this->output = $this->extractDates($dates);

        return $this;
    }

    /**
     * @return mixed
     */
    public function getColumns()
    {
        return $this->columns;
    }


    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->output ? $this->output : $this->data;
    }


    private function extractDates(array $dates)
    {
        $earliest = min(array_keys($this->data));

        foreach ($dates as $key) {

            $result[$key] = array_get($this->data, $key);

            if (is_null($result[$key])) {

                $date = new Carbon($key);
                while (is_null($result[$key]) and $date > $earliest) {
                    $result[$key] = array_get($this->data, $date->subDay(1)->toDateString());
                }
            }
        }
        $result = $this->replaceNullValues($result);

        return $result;
    }


    /**
     * @param $result
     * @return mixed
     */
    private function replaceNullValues($result)
    {
        foreach ($result as $key => $value) {
            if (is_null($value)) $result[$key] = 0;
        }
        return $result;
    }


    private function normalize($data)
    {
        return array_combine(array_column($data, $this->getColumn('Date')), $data);
    }


    /**
     * @return mixed
     */
    private function output()
    {
        return $this->output ? $this->output : $this->data;
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
}