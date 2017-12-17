<?php


namespace App\Models;

use Carbon\Carbon;


class PriceHistory
{

    protected $data;
    protected $column;


    public function __construct(array $history, $column)
    {
        $this->data = $this->normalize($history, $column);
    }


    public function history($attributes = [])
    {
        if (array_has($attributes, 'dates'))
            return $this->historyWithDates($attributes['dates']);

        if (array_has($attributes, 'count'))
            return array_slice($this->data, 0, $attributes['count'], true);

        if (array_has($attributes, 'from') && array_has($attributes, 'to'))
            throw new \Exception("from/to attributres not yet implemented in function 'history'");

        return $this->data;
    }


    public function price($attributes = [])
    {
        $price = null;

        if (array_has($attributes, 'date')) {
            $date = Carbon::parse($attributes['date'])->toDateString();
            $price = array_get($this->data, $date);

        }

        return $price ? [$date => $price] : [key($this->data) => head($this->data)];
    }


public
function priceDate()
{
    return key($this->data);
}


private
function normalize($history, $column)
{
    return array_combine(
        array_column($history, 0),
        array_column($history, $column)
    );
}

private
function historyWithDates(array $keys)
{
    $result = [];
    $earliest = min(array_keys($this->data));

    foreach ($keys as $key) {

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
private
function replaceNullValues($result)
{
    foreach ($result as $key => $value) {
        if (is_null($value)) $result[$key] = 0;
    }
    return $result;
}
}